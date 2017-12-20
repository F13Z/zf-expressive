<?php

namespace Auth;

use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;

class MyAuthAdapterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        // Retrieve any dependencies from the container when creating the instance
        return new MyAuthAdapter(
            $container->get(Adapter::class)
        );
    }
}