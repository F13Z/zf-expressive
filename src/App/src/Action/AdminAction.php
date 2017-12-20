<?php
namespace App\Action;

use Auth\Action\AuthAction;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class AdminAction implements MiddlewareInterface
{
    private $template;
    private $dbAdapter;

    public function __construct(TemplateRendererInterface $template, Adapter $adapter)
    {
        $this->template = $template;
        $this->dbAdapter = $adapter;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $user = $request->getAttribute(AuthAction::class);

        return new HtmlResponse($this->template->render('app::admin'));
    }
}