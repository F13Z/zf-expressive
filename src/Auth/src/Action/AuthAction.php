<?php

namespace Auth\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Diactoros\Response\RedirectResponse;

class AuthAction implements ServerMiddlewareInterface
{
    private $auth;
    private $adapter;

    public function __construct(AuthenticationService $auth, Adapter $adapter)
    {
        $this->auth = $auth;
        $this->adapter = $adapter;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if (!$this->auth->hasIdentity()) {
            return new RedirectResponse('/login?error=session');
        }

        $identity = $this->auth->getIdentity();

        if ($this->isExist($identity) === 0) {
            return new RedirectResponse('/login?error=bad_id');
        }

        return $delegate->process($request->withAttribute(self::class, $identity));
    }

    /**
     * Vérifie la validité de l'identification
     * @param $identity
     * @return int
     * @throws \Zend\Db\Sql\Exception\InvalidArgumentException
     * @throws \Zend\Db\Sql\Exception\RuntimeException
     */
    private function isExist(array $identity): int
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select()
            ->from('users')
            ->where(['id' => (int) $identity['id']])
            ->limit(1);
        $statement = $sql->prepareStatementForSqlObject($select);
        return $statement->execute()->count();
    }
}