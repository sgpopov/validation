<?php

namespace Validation;

use Validation\Contracts\MessageBag as MessageBagContract;

class MessageBag implements MessageBagContract
{
    /**
     * @var array
     */
    protected $messages = [];

    /**
     * MessageBag constructor.
     *
     * @param array $messages
     */
    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }

    /**
     * Add a message to the bag.
     *
     * @param string $key
     * @param string $message
     *
     * @return MessageBag
     */
    public function add(string $key, string $message) : MessageBag
    {
        if ($this->isUnique($key, $message)) {
            $this->messages[$key][] = $message;
        }

        return $this;
    }

    /**
     * Check if a key and message combination already exists.
     *
     * @param string $key
     * @param string $message
     *
     * @return bool
     */
    protected function isUnique(string $key, string $message) : bool
    {
        $messages = (array) $this->messages;

        return !isset($messages[$key]) || !in_array($message, $messages[$key]);
    }

    /**
     * Get the number of messages in the container.
     *
     * @return int
     */
    public function count() : int
    {
        return count($this->all());
    }

    /**
     * Determine if messages exist for a given key.
     *
     * @param array|string $keys
     *
     * @return bool
     */
    public function has($keys = null) : bool
    {
        if (is_null($keys)) {
            return $this->hasAny();
        }

        $keys = is_array($keys) ? $keys : func_get_args();

        foreach ($keys as $key) {
            if (array_key_exists($key, $this->messages)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the message bag has any messages.
     *
     * @return bool
     */
    public function hasAny() : bool
    {
        return $this->count() > 0;
    }

    /**
     * Get the first message from the bag for a given key.
     *
     * @param string $key
     *
     * @return null|string
     */
    public function first(string $key = null)
    {
        $messages = is_null($key) ? $this->all() : $this->get($key);

        return empty($messages) ? null : array_shift($messages);
    }

    /**
     * Get all of the messages from the bag for a given key.
     *
     * @param  string  $key
     *
     * @return array
     */
    public function get(string $key) : array
    {
        $messages = $this->messages[$key] ?? [];

        return (array) $messages;
    }

    /**
     * Get all of the messages for every key in the bag.
     *
     * @return array
     */
    public function all() : array
    {
        $output = [];

        foreach ($this->messages as $key => $message) {
            $output = array_merge($output, $message);
        }

        return $output;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray() : array
    {
        return (array) $this->messages;
    }
}
