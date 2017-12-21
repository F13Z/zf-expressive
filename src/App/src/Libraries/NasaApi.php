<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use Zend\Expressive\Exception\InvalidArgumentException;

class NasaApi
{
    /**
     * @var string
     */
    private $endpoint = 'https://api.nasa.gov/planetary/apod';

    /**
     * @link https://api.nasa.gov/index.html#live_example
     * @var string
     */
    private $key = 'DEMO_KEY';

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var int
     */
    private $interval;

    private $dateFormat = 'Y-m-d';

    /**
     * @var string
     */
    private $order = '-';

    public function __construct(string $key)
    {
        $this->key = $key;
        $this->dateTime = $this->getDefaultDate();
    }

    /**
     * Retourne la date par défaut
     * @return \DateTime
     */
    private function getDefaultDate(): \DateTime
    {
        $dateTime = new \DateTime('now');
        return $dateTime;
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \LogicException
     */
    public function get()
    {
        $client = new Client();
        return $client->request('GET', $this->endpoint, [
            'query' => [
                'api_key'      => $this->key,
                'date'         => $this->getFinalDate(),
            ]
        ]);
    }

    /**
     * Retourne la date finale
     * @return string
     */
    public function getFinalDate(): string
    {
        return $this->getFinalDateTime()->format($this->dateFormat);
    }

    /**
     * Retourne l'objet \DateTime final
     * @return \DateTime
     */
    public function getFinalDateTime(): \DateTime
    {
        if ($this->interval) {
            $this->dateTime->modify('+' . $this->interval . 'days');
        }
        return $this->dateTime;
    }

    public function setDate(string $date)
    {
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            throw new InvalidArgumentException('La date doit être au format YYYY-MM-AA');
        }
        $dateTime = new \DateTime($date);
        $this->dateTime = $dateTime;
    }

    public function setInterval(int $interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }
}