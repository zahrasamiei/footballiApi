<?php

namespace App\Traits;

trait SendHttpRequest
{

    /** send get request to given url
     * @param $url
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function sendGetRequest($url, $data = [])
    {
        $client = new \GuzzleHttp\Client();

        #send get request
        $response = $client->get(
            $url,
            [
                'http_errors' => false
            ]
        );

        #give http code
        $httpCode = $response->getStatusCode();
        #get http description
        $httpDescription = $response->getReasonPhrase();

        return [
          "response" => json_decode($response->getBody()->getContents(),true),
          "httpCode" => $httpCode,
          "httpDescription" => $httpDescription,
        ];
    }

}
