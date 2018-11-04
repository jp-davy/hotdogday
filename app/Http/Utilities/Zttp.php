<?php

namespace App\Http\Utilities;

class Zttp
{
    static function __callStatic($method, $args)
    {
        return ZttpRequest::new()->{$method}(...$args);
    }
}

class ZttpRequest
{
    function __construct()
    {
        $this->headers = [];
        $this->bodyFormat = 'json';
    }

    static function new()
    {
        return new self;
    }

    function asJson()
    {
        $this->bodyFormat = 'json';
        return $this->contentType('application/json');
    }

    function asFormParams()
    {
        $this->bodyFormat = 'form_params';
        return $this->contentType('application/x-www-form-urlencoded');
    }

    function contentType($contentType)
    {
        return $this->withHeaders(['Content-Type' => $contentType]);
    }

    function accept($header)
    {
        return $this->withHeaders(['Accept' => $header]);
    }

    function withHeaders($headers)
    {
        return tap($this, function ($request) use ($headers) {
            $this->headers = array_merge($this->headers, $headers);
        });
    }

    function get($url, $queryParams = [])
    {
        return $this->_send('GET', $url, [
            'query' => $queryParams,
        ]);
    }

    function post($url, $params = [])
    {
        return $this->_send('POST', $url, [
            $this->bodyFormat => $params,
        ]);
    }

    function _send($method, $url, $options)
    {
        $response = (new \GuzzleHttp\Client)->request($method, $url, array_merge([
            'http_errors' => false,
            'headers' => $this->headers,
        ], $options));

        return new ZttpResponse($response);
    }
}

class ZttpResponse
{
    function __construct($response)
    {
        $this->response = $response;
    }

    function body()
    {
        return (string) $this->response->getBody();
    }

    function json()
    {
        return json_decode($this->response->getBody(), true);
    }

    function header($header)
    {
        return $this->response->getHeaderLine($header);
    }

    function status()
    {
        return $this->response->getStatusCode();
    }

    function isSuccess()
    {
        return in_array($this->status(), array_merge(range(200, 208), [226]));
    }

    function isRedirect()
    {
        return in_array($this->status(), range(300, 308));
    }

    function __call($method, $args)
    {
        return $this->response->{$method}(...$args);
    }
}

class ZttpException extends \RuntimeException
{

}
