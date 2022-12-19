<?php

namespace Corviz\HttpMessage;

use ArrayAccess;
use Stringable;

class Query implements Stringable, ArrayAccess
{
    /**
     * @var array
     */
    private array $data = [];

    /**
     * @param string $queryString
     */
    public function __construct(string $queryString)
    {
        parse_str($queryString, $this->data);
    }

    /**
     * @param string $index
     *
     * @return bool
     */
    public function has(string $index): bool
    {
        return isset($this->data[$index]);
    }

    /**
     * @param string $index
     *
     * @return mixed
     */
    public function &get(string $index): mixed
    {
        return $this->data[$index];
    }

    /**
     * @param string $index
     * @param mixed $value
     *
     * @return $this
     */
    public function set(string $index, mixed $value)
    {
        $this->data[$index] = $value;

        return $this;
    }

    /**
     * @param mixed $encoding
     * @return string
     */
    public function toString(mixed $encoding = null): string
    {
        if (is_null($encoding)) {
            return http_build_query($this->data);
        }

        return http_build_query($this->data, encoding_type: $encoding);
    }

    /**
     * @param string $index
     *
     * @return $this
     */
    public function unset(string $index)
    {
        unset($this->data[$index]);

        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function &__get(string $name)
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->set($name, $value);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset)
    {
        return $this->has($offset);
    }

    /**
     * @inheritDoc
     */
    public function &offsetGet(mixed $offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value)
    {
        return $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset)
    {
        $this->unset($offset);
    }
}
