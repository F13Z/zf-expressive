<?php

namespace Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Sql;

class MyAuthAdapter implements AdapterInterface
{
    private $password;
    private $username;
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    /**
     * Performs an authentication attempt
     *
     * @return Result
     */
    public function authenticate()
    {
        // Retrieve the user's information (e.g. from a database)
        // and store the result in $row (e.g. associative array).
        // If you do something like this, always store the passwords using the
        // PHP password_hash() function!

        // 'password' => password_hash($this->password, PASSWORD_DEFAULT)

        // Vérifie que l'utilisateur existe en DB
        $identity = $this->getIdentify();
        if ($identity->count() === 0) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $this->username, ["L'utilisateur est inexistant."]);
        }

        // Retourne les informations en DB
        $row = $identity->current();

        // Vérifie le mot de passe
        if (password_verify($this->password, $row['password'])) {
            return new Result(Result::SUCCESS, $row);
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->username, ["Le mot de passe est incorrecte."]);
    }

    /**
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     * @throws \Zend\Db\Sql\Exception\InvalidArgumentException
     * @throws \Zend\Db\Sql\Exception\RuntimeException
     */
    private function getIdentify(): ResultInterface
    {
        $sql = new Sql($this->adapter);
        $select = $sql
            ->select()
            ->columns(['id', 'password'])
            ->from('users')
            ->where(['name' => $this->username])
            ->limit(1);
        $statement = $sql->prepareStatementForSqlObject($select);
        return $statement->execute();
    }
}