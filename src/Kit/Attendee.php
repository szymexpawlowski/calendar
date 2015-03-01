<?php

namespace Kit;

/**
 * Class Attendee
 * 
 * @package Kit
 */
class Attendee
{
    /**
     * @var array
     */
    private $timeSlots;

    /**
     * @var string
     */
    private $timeSlotsCached = [];

    /**
     * @var DateHelper
     */
    private $dateHelper;

    /**
     * @param array      $timeSlots
     * @param DateHelper $dateHelper
     */
    public function __construct(array $timeSlots, DateHelper $dateHelper)
    {
        $this->timeSlots = $timeSlots;
        $this->dateHelper = $dateHelper;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getTimeSlotsAsBinaryArray(\DateTime $start, \DateTime $end)
    {
        if ($start >= $end) {
            throw new \InvalidArgumentException('Start date has to be earlier than end date!');
        }

        $length = $this->dateHelper->computeIndex($start, $end);
        $result = array_fill(0, $length + 1, 0);
        $timeSlots = $this->filterTimeSlots($start, $end);

        foreach ($timeSlots as $timeSlot) {

            $from = $this->dateHelper->computeIndex($start, $timeSlot->getFromInTimeZone($start->getTimezone()));
            $to = $this->dateHelper->computeIndex($start, $timeSlot->getToInTimeZone($start->getTimezone()));
            $numberOfOccurrences = $to - $from;

            array_splice($result, $from, $numberOfOccurrences, array_fill(0, $numberOfOccurrences, 1));
        }

        return $result;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return mixed
     */
    private function filterTimeSlots(\DateTime $start, \DateTime $end)
    {
        if (!$this->isCached($start, $end)) {
            $this->timeSlotsCached[$start->getTimestamp()][$end->getTimestamp()] = $this->filterByDateRange($start, $end);
        }

        return $this->timeSlotsCached[$start->getTimestamp()][$end->getTimestamp()];
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return array
     */
    private function filterByDateRange(\DateTime $start, \DateTime $end)
    {
        $timeSlots = $this->timeSlots;
        foreach ($timeSlots as $key => $timeSlot) {

            if (!$this->isInRange($start, $end, $timeSlot)) {
                unset($timeSlots[$key]);
            }
        }

        return $timeSlots;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @param TimeSlot  $timeSlot
     *
     * @return bool
     */
    private function isInRange(\DateTime $start, \DateTime $end, TimeSlot $timeSlot)
    {
        return $start <= $timeSlot->getFromInTimeZone($start->getTimezone()) &&
            $timeSlot->getToInTimeZone($end->getTimezone()) <= $end;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return bool
     */
    private function isCached(\DateTime $start, \DateTime $end)
    {
        return !empty($this->timeSlotsCached[$start->getTimestamp()][$end->getTimestamp()]);
    }
}
