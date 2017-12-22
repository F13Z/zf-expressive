<?php
namespace AppTest\Libraries;

use App\Libraries\NasaApi;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Zend\Expressive\Exception\InvalidArgumentException;


class NasaApiTest extends TestCase
{
    public function testConstruct(): void
    {
        $api = new NasaApi('DEMO_KEY');
        $dt = new \DateTime('now');
        $date = $dt->format($api->getDateFormat());
        $this->assertSame($date, $api->getFinalDate());
    }

    public function testGet(): void
    {
        $client = $this->createMock(Client::class);
        $client->method('request')->willReturn(ResponseInterface::class);
        $api = new NasaApi('DEMO_KEY');
        $this->assertInstanceOf(ResponseInterface::class, $api->get());
    }

    public function testDate(): void
    {
        $api = new NasaApi('DEMO_KEY');
        $api->setDate('2018-01-01');
        $this->assertSame('2018-01-01', $api->getFinalDate());
    }

    public function testDateInterval(): void
    {
        $api = new NasaApi('DEMO_KEY');
        $api->setDate('2018-01-01');
        $api->setInterval(1);
        $this->assertSame('2018-01-02', $api->getFinalDate());
    }

    public function testDateException(): void
    {
        $api = new NasaApi('DEMO_KEY');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('La date doit être au format YYYY-MM-AA');
        $api->setDate('01-01-2018');
    }
}