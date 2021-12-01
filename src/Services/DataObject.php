<?php

namespace ClimbingCard\Services;

use ClimbingCard\Services\Contracts\Arrayable;
use ClimbingCard\Services\Contracts\Jsonable;
use ClimbingCard\Services\Str;

abstract class DataObject implements Arrayable, Jsonable
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Convert key to set type when using accessors.
     *
     * Accepted types are "json", "array", "int" and "float".
     * "json" and "array" are quite similar, only difference is that "array"
     * will be decoded using ASSOC flag set to true.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Init new data object
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Fill up object data
     *
     * @param array $data
     */
    public function fill(array $data)
    {
        $this->data = $data;
    }

    /**
     * Return object as array
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];

        // Cast data
        if (count($this->data) > 0) {
            foreach ($this->data as $key => $value) {
                $data[$key] = $this->cast($key, $value);
            }
        }

        // Process appends and add them to array as well
        $appends = [];

        if (count($this->appends) > 0) {
            foreach ($this->appends as $attribute) {
                $appends[$attribute] = $this->__get($attribute);
            }
        }

        return array_merge($data + $appends);
    }

    /**
     * Return object as array
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return @json_encode($this->toArray(), $options);
    }

    /**
     * Get object property
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        $attributeMethod = 'get' . Str::studly($key) . 'Attribute';

        if (method_exists($this, $attributeMethod)) {
            return $this->cast($key, $this->$attributeMethod());
        } elseif (isset($this->data[$key])) {
            return $this->cast($key, $this->data[$key]);
        } elseif (isset($this->data[Str::snake($key)])) {
            return $this->cast($key, $this->data[Str::snake($key)]);
        }
    }

    /**
     * Set object property
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public function __set($key, $value)
    {
        $attributeMethod = 'set' . Str::studly($key) . 'Attribute';

        if (method_exists($this, $attributeMethod)) {
            return $this->$attributeMethod($value);
        }

        return $this->data[$key] = $value;
    }

    /**
     * Override isset
     *
     * @param  string $key
     * @return bool
     */
    public function __isset($key)
    {
        $attribute = $this->$key;

        return !empty($attribute);
    }

    /**
     * Cast attribute value depending on $casts array when __get or toArray
     * methods are used.
     *
     * Accepted types are "json", "array", "int" and "float".
     * "json" and "array" are quite similar, only difference is that "array"
     * will be decoded using ASSOC flag set to true.
     *
     * @param   string  $key
     * @param   mixed  $value
     *
     * @return  mixed
     */
    protected function cast($key, $value)
    {
        $normalizedKey = Str::snake($key);

        if (!isset($this->casts[$normalizedKey])) {
            return $value;
        }
        $type = $this->casts[$normalizedKey];

        switch ($type) {
            case 'json':
                return !empty($value) ? json_decode($value) : null;
            case 'array':
                return !empty($value) ? json_decode($value, true) : null;
            case 'int':
                return !empty($value) || (int) $value === 0 ? (int) $value : null;
            case 'float':
                return !empty($value) || (int) $value === 0  ? (float) $value : null;
            case 'bool':
                return !empty($value) ? true : false;
            default:
                return $value;
        }
    }
}
