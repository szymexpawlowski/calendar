<?php

namespace Kit;

class DateHelper
{
    const MINUTE = 60;

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return float
     */
    public function computeIndex(\DateTime $start, \DateTime $end)
    {
        $timeDifference = $this->computeTimeDifference($start, $end);

        return floor($timeDifference / self::MINUTE);
    }

    /**
     * @param array     $sequences
     * @param \DateTime $start
     *
     * @return array
     */
    public function convertSequencesToTimeSlots($sequences, \DateTime $start)
    {
        $result = [];
        foreach ($sequences as $sequence) {
            $result[] = $this->convertSequenceToTimeSlot($sequence->getFrom(), $sequence->getTo(), $start);
        }

        return $result;
    }

    /**
     * @param int       $fromIndex
     * @param int       $toIndex
     * @param \DateTime $start
     *
     * @return TimeSlot
     */
    public function convertSequenceToTimeSlot($fromIndex, $toIndex, \DateTime $start)
    {
        $from = $this->createDateTime($start, $fromIndex, self::MINUTE);
        $to = $this->createDateTime($start, $toIndex, self::MINUTE);

        return new TimeSlot($from, $to);
    }

    /**
     * @param \DateTime $dateTime
     * @param int       $timestampToAdd
     * @param int       $unit
     *
     * @return \DateTime
     */
    private function createDateTime(\DateTime $dateTime, $timestampToAdd, $unit)
    {
        $result = new \DateTime();
        $result->setTimezone($dateTime->getTimezone());
        $result->setTimestamp($dateTime->getTimestamp() + $timestampToAdd * $unit);

        return $result;
    }

    /**
     * @param $timestamp
     *
     * @return int
     */
    private function stripSeconds($timestamp)
    {
        return $timestamp - ($timestamp % 60);
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return int
     */
    private function computeTimeDifference(\DateTime $start, \DateTime $end)
    {
        return $this->stripSeconds($end->getTimestamp()) - $this->stripSeconds($start->getTimestamp());
    }
}
