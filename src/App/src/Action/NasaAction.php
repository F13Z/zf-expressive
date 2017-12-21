<?php

namespace App\Action;

use App\Libraries\NasaApi;
use GuzzleHttp\Exception\ClientException;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

class NasaAction implements MiddlewareInterface
{
    private $router;
    private $template;
    private $nasaApi;

    public function __construct(NasaApi $nasaApi, Template\TemplateRendererInterface $template = null)
    {
        $this->template = $template;
        $this->nasaApi = $nasaApi;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        try {
            $response = $this->nasaApi->get();
            $content = json_decode((string) $response->getBody(), true);
            $return = ['pictures' => $content];
        } catch (ClientException $e) {
            $return = ['error' => [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]];
        }

        return new HtmlResponse($this->template->render('app::nasa', $return));
    }
}
