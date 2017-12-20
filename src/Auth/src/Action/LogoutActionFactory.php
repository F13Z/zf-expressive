<?php

namespace Auth\Action;

use Psr\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class LogoutActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LogoutAction(
            $container->get(AuthenticationService::class)
        );
    }
}