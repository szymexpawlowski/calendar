<?php

namespace Kit;

class Sequence
{
    /**
     * @var int
     */
    private $from;

    /**
     * @var int
     */
    private $length;

    /**
     * @var int
     */
    private $value;

    /**
     * @param int $from
     * @param int $length
     * @param int $value
     */
    public function __construct($from, $length, $value)
    {
        $this->from = $from;
        $this->length = $length;
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return isset($this->from);
    }

    /**
     * @param int $value
     *
     * @return bool
     */
    public function isEqualTo($value)
    {
        return $this->value === $value;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @var int
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return int
     */
    public function getTo()
    {
        return $this->from + $this->length;
    }

    /**
     * @param int $value
     */
    public function incrementLength($value = 1)
    {
        $this->length += $value;
    }

    /**
     * @param int $length
     *
     * @return bool
     */
    public function hasAtLeast($length)
    {
        return $this->length >= $length;
    }
}
