<?php

namespace App\Core;

class Request
{
    private $queryParams;
    private $postData;

    /**
     * Request constructor. Initializes query parameters and post data.
     */
    public function __construct()
    {
        $this->queryParams = $_GET;
        $this->postData = $this->getParsedBodyData();
    }

    /**
     * Get a query parameter by key.
     *
     * @param string $key The query parameter key.
     * @param mixed $default The default value if the key does not exist.
     * @return mixed The value of the query parameter or default if not set.
     */
    public function getQueryParam($key, $default = null)
    {
        return isset($this->queryParams[$key]) ? $this->queryParams[$key] : $default;
    }

    /**
     * Get a POST parameter by key.
     *
     * @param string $key The POST parameter key.
     * @param mixed $default The default value if the key does not exist.
     * @return mixed The value of the POST parameter or default if not set.
     */
    public function getPostData($key, $default = null)
    {
        return isset($this->postData[$key]) ? $this->postData[$key] : $default;
    }

    /**
     * Get all query parameters.
     *
     * @return array The array of all query parameters.
     */
    public function getAllQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Get all POST data.
     *
     * @return array The array of all POST data.
     */
    public function getAllPostData()
    {
        return $this->postData;
    }

    /**
     * Get the request URI (path only, without query string).
     *
     * @return string The request URI path.
     */
    public function getUri()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        // Remove query string if present
        $pos = strpos($uri, '?');
        if ($pos !== false) {
            $uri = substr($uri, 0, $pos);
        }
        return rtrim($uri, '/') ?: '/';
    }

    /**
     * Get the HTTP request method (GET, POST, etc.).
     *
     * @return string The HTTP request method.
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Parse and return the request body data based on HTTP method.
     *
     * @return array The parsed body data.
     */
    private function getParsedBodyData()
    {
        if ($this->getMethod() === 'POST') {
            return $_POST;
        } elseif ($this->getMethod() === 'PUT' || $this->getMethod() === 'PATCH') {
            $rawInput = file_get_contents('php://input');
            parse_str($rawInput, $putData);
            return $putData;
        } else {
            return [];
        }
    }
}