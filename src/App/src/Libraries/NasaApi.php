<?php

namespace App\Libraries;

use GuzzleHttp\Client;

class NasaApi
{
    private $endpoint = 'https://api.nasa.gov/planetary/apod';
    private $timeZone = 'Europe/Paris';
    private $key = 'DEMO_KEY'; // https://api.nasa.gov/index.html#live_example

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function get()
    {
        $date = $this->getDateTime();

        $client = new Client();
        $response = $client->request('GET', $this->endpoint, [
            'query' => [
                'api_key'      => $this->key,
                'date'         => $date->format('Y-m-d'),
            ]
        ]);

        return $response;
    }

    public function setTimeZone(string $timezone)
    {
        $this->timeZone = $timezone;
    }

    private function getDateTime()
    {
        $timezone = new \DateTimeZone($this->timeZone);
        $dateTime = new \DateTime('now');
        $dateTime->setTimezone($timezone);
        return $dateTime;
    }

}