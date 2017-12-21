<?php

namespace App\Action;

use App\Libraries\NasaApi;
use GuzzleHttp\Exception\ClientException;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

class NasaAction implements MiddlewareInterface
{
    private $template;
    private $nasaApi;

    public function __construct(NasaApi $nasaApi, Template\TemplateRendererInterface $template = null)
    {
        $this->template = $template;
        $this->nasaApi = $nasaApi;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $datas = [];

        // Request
        $date = $request->getAttribute('date');
        if (! empty($date)) {
            $this->nasaApi->setDate($date);
            $datas['date'] = $date;
        }

        // Get content
        try {
            $response = $this->nasaApi->get();
            $content = json_decode((string) $response->getBody(), true);
            $datas['pictures'] = $content;
        } catch (ClientException $e) {
            $datas['error'] = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ];
        }

        // Link
        $dateCurrent = new \DateTime('now');
        $dateApi = $this->nasaApi->getFinalDateTime();
        $dateFormat = $this->nasaApi->getDateFormat();

        if ($dateCurrent->format($dateFormat) === $dateApi->format($dateFormat)) {
            $dateApi->modify('-1 day');
            $datas['linkPrevious'] = '/date/' . $dateApi->format($dateFormat);
        } else {
            $dateApi->modify('-1 day');
            $datas['linkPrevious'] = '/date/' . $dateApi->format($dateFormat);
            $dateApi->modify('+2 day');
            $datas['linkNext'] =  '/date/' . $dateApi->format($dateFormat);
        }



        return new HtmlResponse($this->template->render('app::nasa', $datas));
    }
}
