<?php

namespace App\Factory;

use App\Libraries\NasaApi;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Factory\FactoryInterface;

class NasaApiFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        if (!isset($config['application']['nasa_api']['api_key'])) {
            throw new ServiceNotCreatedException('nasa_api > api_key doit être configuré');
        }

        return new NasaApi($config['application']['nasa_api']['api_key']);
    }
}
