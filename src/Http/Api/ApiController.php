<?php

namespace ClimbingCard\Http\Api;

use WP_REST_Response;

class ApiController
{
    /**
     * Cache expiration in minutes
     *
     * @var int
     */
    protected static $cacheTtl = 5;

    /**
     * Full path to the repository class
     *
     * @var string
     */
    protected static $repositoryClass;

    /**
     * Data repository instance for data structure
     *
     * @var mixed
     */
    protected static $repository;

    /**
     * Abort execution
     *
     * @param $code
     */
    public static function abort($code)
    {
        echo 'Error: ' . $code;
        die();
    }

    /**
     * Fetch from transient API
     *
     * @param  string $key
     * @return mixed
     */
    public static function cacheGet($key)
    {
        $payload = get_transient($key);

        return @json_decode($payload) ?: $payload;
    }

    /**
     * Save to transient API
     *
     * @param string $key
     * @param mixed  $payload
     * @param int    $ttl
     */
    public static function cachePut($key, $payload, $ttl = 0)
    {
        $cacheTtl = ($ttl ?: self::$cacheTtl) * 60;

        if (!is_string($payload)) {
            $payload = @json_encode($payload);
        }

        set_transient($key, $payload, $cacheTtl);
    }

    /**
     * Setup the API response
     *
     * @param  mixed $payload
     * @param  int   $code
     * @param  array $options
     * @param array  $headers
     * @return WP_REST_Response
     */
    public static function apiResponse($payload, $code = 200, $options = [], $headers = [])
    {
        $response = ['status' => $code];

        // Add message?
        if (is_array($payload) && isset($payload['message'])) {
            $response['message'] = $payload['message'];
        } elseif (is_object($payload) && isset($payload->message)) {
            $response['message'] = $payload->message;
        }

        // Add payload
        $response['data'] = $payload;

        // Add meta data if needed
        if (isset($options['meta'])) {
            $response['meta'] = $options['meta'];
        }

        // Add link data if needed
        if (isset($options['links'])) {
            $response['links'] = $options['links'];
        }

        return new WP_REST_Response($response, $code, $headers);
    }

    /**
     * Return API error
     *
     * @param string $message
     * @param string $code
     * @param int    $status
     * @param array  $data
     * @param array  $options
     * @return WP_REST_Response
     */
    public static function apiErrorResponse($message, $code = null, $status = 404, $data = [], $options = [])
    {
        $response = [
            'code'     => $code ?: 'error',
            'message'  => $message,
            'data'     => array_merge(['status' => $status], $data),
        ];

        // Add meta data if needed
        if (isset($options['meta'])) {
            $response['meta'] = $options['meta'];
        }

        return new WP_REST_Response($response, $status);
    }

    /**
     * Create repository instance
     *
     * @param  string $class
     * @return mixed
     */
    public static function repository($class = null)
    {
        if (!static::$repository) {
            if ($class) {
                static::$repository = new $class;
            } else {
                static::$repository = new static::$repositoryClass;
            }
        }

        return static::$repository;
    }
}
