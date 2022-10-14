<?php

namespace Application\Lib;

use Application\Lib\RequestMethods;

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

    public function getRequest(array $params = []): array
    {
        $context = stream_context_create($this->options(RequestMethods::GET, $params));
        $result = file_get_contents($this->query(), false, $context);
        return json_decode($result);
    }

    public function postRequest(array $params = []): void
    {
        $context = stream_context_create($this->options(RequestMethods::POST, $params));
        file_get_contents($this->query(), false, $context);
    }

    public function patchRequest(array $params = []): void
    {
        $context = stream_context_create($this->options(RequestMethods::PATCH, $params));
        file_get_contents($this->query($params), false, $context);
    }

    public function deleteRequest(array $params = []): void
    {
        $context = stream_context_create($this->options(RequestMethods::DELETE, $params));
        file_get_contents($this->query($params), false, $context);
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
