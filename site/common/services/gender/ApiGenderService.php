<?php

namespace common\services\Gender;

use common\services\gender\GenderServiceInterface;

class ApiGenderService implements GenderServiceInterface
{

    private $country;
    private $api_route;

    public function __construct(string $country, string $api_route)
    {
        $this->country = $country;
        $this->api_route = $api_route;
    }

    public function get(string $name) 
    {
        $request_name = urlencode($name);
        $url = $this->api_route . '?name=' . $request_name; 

        var_dump($url);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        var_dump(json_decode($response), true);

        return 1;
    }

}