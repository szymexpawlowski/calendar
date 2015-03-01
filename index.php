<?php

require_once 'vendor/autoload.php';

use Kit\Attendee;
use Kit\Calendar;
use Kit\TimeSlot;
use Kit\DateHelper;
use Kit\SequenceFinder;

$freeTimeSlot1 = new TimeSlot(new \DateTime('2015-01-10 12:04'), new \DateTime('2015-01-10 12:06'));
$freeTimeSlot2 = new TimeSlot(new \DateTime('2015-01-10 12:08'), new \DateTime('2015-01-10 12:10'));
$freeTimeSlot3 = new TimeSlot(new \DateTime('2015-01-10 12:00'), new \DateTime('2015-01-10 12:01'));
$freeTimeSlot4 = new TimeSlot(new \DateTime('2015-01-10 12:07'), new \DateTime('2015-01-10 12:10'));
$freeTimeSlot5 = new TimeSlot(new \DateTime('2015-01-10 12:00'), new \DateTime('2015-01-10 12:02'));
$freeTimeSlot6 = new TimeSlot(new \DateTime('2015-01-10 12:19'), new \DateTime('2015-01-10 12:20'));
$freeTimeSlot7 = new TimeSlot(new \DateTime('2015-01-10 12:07'), new \DateTime('2015-01-10 12:10'));

$dateHelper = new DateHelper();
$attendee1 = new Attendee([$freeTimeSlot1, $freeTimeSlot2], $dateHelper);
$attendee2 = new Attendee([$freeTimeSlot3, $freeTimeSlot4], $dateHelper);
$attendee3 = new Attendee([$freeTimeSlot5, $freeTimeSlot6, $freeTimeSlot7], $dateHelper);

$calendar = new Calendar($dateHelper, new SequenceFinder);
$slots = $calendar->findEmptySlots(
    [$attendee1, $attendee2, $attendee3],
    2,
    1,
    new \DateTime('2015-01-10 12:00'),
    new \DateTime('2015-01-10 12:10')
);