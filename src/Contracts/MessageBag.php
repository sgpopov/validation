<?php

namespace SGP\Validation\Contracts;

interface MessageBag
{
    /**
     * Add a message to the bag.
     *
     * @param string $key
     * @param string $message
     *
     * @return $this
     */
    public function add(string $key, string $message);

    /**
     * Determine if messages exist for a given key.
     *
     * @param array|string $key
     *
     * @return bool
     */
    public function has($key = null) : bool;

    /**
     * Get all of the messages from the bag for a given key.
     *
     * @param  string  $key
     *
     * @return array
     */
    public function get(string $key);

    /**
     * Get all of the messages for every key in the bag.
     *
     * @return array
     */
    public function all();

    /**
     * Get the first message from the bag for a given key.
     *
     * @param string $key
     *
     * @return string
     */
    public function first(string $key = null);

    /**
     * Get the number of messages in the container.
     *
     * @return int
     */
    public function count() : int;

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray() : array;
}
