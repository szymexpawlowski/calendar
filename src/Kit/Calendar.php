<?php

namespace Kit;

/**
 * Class Calendar
 *
 * @package Kit
 */
class Calendar
{
    /**
     * @var DateHelper
     */
    private $dateHelper;

    /**
     * @var SequenceFinder
     */
    private $sequenceFinder;

    /**
     * @param DateHelper     $dateHelper
     * @param SequenceFinder $sequenceFinder
     */
    public function __construct(DateHelper $dateHelper, SequenceFinder $sequenceFinder)
    {
        $this->dateHelper = $dateHelper;
        $this->sequenceFinder = $sequenceFinder;
    }

    /**
     * @param array     $attendees       array of attendees
     * @param int       $duration        length of the meeting in minutes
     * @param int       $timeSlotsToFind number of free time slots to find
     * @param \DateTime $start           start date
     * @param \DateTime $end             end date
     *
     * @throws \InvalidArgumentException
     */
    public function findEmptySlots(array $attendees, $duration, $timeSlotsToFind, \DateTime $start, \DateTime $end)
    {
        if (count($attendees) < 2) {
            throw new \InvalidArgumentException('There has to be at least two attendees!');
        }

        if ($start >= $end) {
            throw new \InvalidArgumentException('Start date has to be earlier than end date!');
        }

        if ($duration < 1) {
            throw new \InvalidArgumentException('Duration has to be at least one minute!');
        }

        if ($timeSlotsToFind < 1) {
            throw new \InvalidArgumentException('There has to be at least one time slots to find!');
        }

        $timeSlotsBinary = $this->mergeAttendeesTimeSlotsToBinaryArray($attendees, $start, $end);
        $sequences = $this->sequenceFinder->findSequences($timeSlotsBinary, 1, $duration, $timeSlotsToFind);
        $timeSlots = $this->dateHelper->convertSequencesToTimeSlots($sequences, $start);
        $this->printTimeSlots($timeSlots, $timeSlotsToFind);
    }

    /**
     * @param array     $attendees
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return array
     */
    private function mergeAttendeesTimeSlotsToBinaryArray(array $attendees, \DateTime $start, \DateTime $end)
    {
        $result = [];
        foreach ($attendees as $attendee) {

            if (!$result) {
                $result = $attendee->getTimeSlotsAsBinaryArray($start, $end);
            } else {
                $attendeeTimeSlotsBinary = $attendee->getTimeSlotsAsBinaryArray($start, $end);
                array_walk(
                    $result,
                    function (&$element, $index, $attendeeTimeSlotsBinary) {
                        $element &= $attendeeTimeSlotsBinary[$index];
                    },
                    $attendeeTimeSlotsBinary
                );
            }
        }

        return $result;
    }

    /**
     * Usually there should be some printing class implementing Printable interface but I guess
     * in context of this task it doesn't make much sense.
     *
     * @param array $timeSlots
     * @param int   $timeSlotsToFind
     */
    private function printTimeSlots($timeSlots, $timeSlotsToFind)
    {
        if (count($timeSlots) === $timeSlotsToFind) {

            foreach ($timeSlots as $timeSlot) {
                echo "From " . $timeSlot->getFrom()->format('Y-m-d H:i') .
                    " to " . $timeSlot->getTo()->format('Y-m-d H:i');
            }
        } else {
            echo "Couldn't find $timeSlotsToFind free time slots";
        }

        echo PHP_EOL;
    }
}
