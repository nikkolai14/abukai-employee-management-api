<?php

namespace App\Core;

class Response
{
    /**
     * Send a JSON response and terminate the script.
     *
     * @param mixed $data The data to encode as JSON.
     * @param int $status The HTTP status code (default 200).
     * @return void
     */
    public static function json($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    /**
     * Send a JSON error response and terminate the script.
     *
     * @param string $message The error message.
     * @param int $status The HTTP status code (default 400).
     * @return void
     */
    public function error($message, $status = 400)
    {
        return self::json(['error' => $message], $status);
    }

    /**
     * Send a JSON errors response and terminate the script.
     *
     * @param array $errors The array of error messages.
     * @param int $status The HTTP status code (default 400).
     * @return void
     */
    public function errors($data, $status = 400)
    {
        return self::json(['errors' => $data], $status);
    }

    /**
     * Send a JSON success response and terminate the script.
     *
     * @param mixed $data The data to include in the response.
     * @param int $status The HTTP status code (default 200).
     * @return void
     */
    public function success($data, $status = 200)
    {
        return self::json(['data' => $data], $status);
    }
}