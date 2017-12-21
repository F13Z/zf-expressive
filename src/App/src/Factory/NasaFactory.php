<?php

namespace App\Factory;

use App\Action\NasaAction;
use App\Libraries\NasaApi;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class NasaFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $nasaApi = $container->get(NasaApi::class);
        $template = $container->get(TemplateRendererInterface::class);

        return new NasaAction($nasaApi, $template);
    }
}
