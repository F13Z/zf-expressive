<?php

namespace Auth\Factory;

use Auth\Action\AuthAction;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;

class AuthActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthAction(
            $container->get(AuthenticationService::class),
            $container->get(Adapter::class)
        );
    }
}