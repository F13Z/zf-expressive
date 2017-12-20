<?php

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AdminFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $template = $container->get(TemplateRendererInterface::class);
        $adapter = $container->get(Adapter::class);

        return new AdminAction($template, $adapter);
    }
}
