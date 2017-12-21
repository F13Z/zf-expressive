<?php

namespace Auth;

use Zend\Authentication\AuthenticationService;

/**
 * The configuration provider for the Auth module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                Action\AuthAction::class => Factory\AuthActionFactory::class,
                Action\LoginAction::class => Factory\LoginActionFactory::class,
                Action\LogoutAction::class => Factory\LogoutActionFactory::class,
                Action\TestAction::class => Factory\TestActionFactory::class,
                AuthenticationService::class => AuthenticationServiceFactory::class,
                MyAuthAdapter::class => MyAuthAdapterFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'auth'    => [__DIR__ . '/../templates/app'],
                // 'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
