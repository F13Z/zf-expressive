<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

/** @var \Zend\Expressive\Application $app */

// Public
$app->get('/', App\Action\HomePageAction::class, 'home');
$app->get('/api/ping', App\Action\PingAction::class, 'api.ping');
$app->get('/test', App\Action\TestAction::class, 'test');

$app->get('/nasa[/date/:date]', App\Action\NasaAction::class, 'nasa')
    ->setOptions([
        'defaults' => [
            'date' => '',
        ],
        'constraints' => [
            'date' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])',
        ]
    ]);

// Identification
$app->route('/login', Auth\Action\LoginAction::class, ['GET', 'POST'], 'login');
$app->get('/logout', Auth\Action\LogoutAction::class, 'logout');

// Admin
$app->get('/admin', [
    Auth\Action\AuthAction::class,
    App\Action\AdminAction::class,
], 'admin');
$app->get('/admin/test',Auth\Action\TestAction::class, 'admin.test');

