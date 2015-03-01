<?php

namespace Kit;

class TimeSlot
{
    /**
     * @var \DateTime
     */
    private $from;

    /**
     * @var \DateTime
     */
    private $to;

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     */
    public function __construct(\DateTime $from, \DateTime $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param \DateTimeZone $timeZone
     *
     * @return \DateTime
     */
    public function getFromInTimeZone(\DateTimeZone $timeZone)
    {
        $from = clone($this->from);
        $from->setTimezone($timeZone);

        return $from;
    }

    /**
     * @param \DateTimeZone $timeZone
     *
     * @return \DateTime
     */
    public function getToInTimeZone($timeZone)
    {
        $to = clone($this->to);
        $to->setTimezone($timeZone);

        return $to;
    }

    /**
     * @return \DateTime
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return \DateTime
     */
    public function getTo()
    {
        return $this->to;
    }
}
