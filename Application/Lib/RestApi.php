<?php

namespace Application\Lib;

use Application\Enums\RequestMethods;

class RestApi
{
    public const LINK = 'https://gorest.co.in/public/v2/users/';

    public function query(array $params = []): string
    {
        $result = self::LINK;
        if (!empty($params)) {
            foreach ($params as $value) {
                $result .= $value;
                break;
            }
        }
        return $result;
    }

    public function request(RequestMethods $method, array $params = []): array
    {
        $context = stream_context_create($this->options($method, $params));
        if ($method == RequestMethods::GET or $method == RequestMethods::POST){
            $result = file_get_contents($this->query(), false, $context);
        } else {
            $result = file_get_contents($this->query($params), false, $context);
        }

        return (array)json_decode($result);
    }

    private function options(RequestMethods $method, array $params): array
    {
        return [
            'http' => [
                'header' => "Accept: application/json\r\n" .
                    "Context-Type: application/json\r\n" .
                    "Content-Type: application/x-www-form-urlencoded\r\n" .
                    "Authorization: Bearer " . $_ENV['GOREST_TOKEN'] . "\r\n",
                'method' => $method->name,
                'content' => http_build_query($params),
            ]
        ];
    }
}
