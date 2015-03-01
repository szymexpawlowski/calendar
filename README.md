#Finding empty slot in calendar

##Problem: Arranging a meeting can be very hard task when you have to invite many people. Some of them already have their time-slots booked, others work in a different timezone. That's why we want to automate that process.

##Task: Write a code (in the language of your choice) which finds available time-slots for a meeting that everyone can attend. Please remember: It's only small coding task, we don't want to waste your time, solution doesn't require GUI and features like storing data. Solution should include code that is responsible for calculations of available time-slots and example data - in format that could be easily modified to feed different input (we should be able to run code with your data set).

##Input parameters:
* list of attendees (every attendee can have different working hours and different time-slots already booked)
* meeting length (in unit of your choice)
* (Integer) Number of possible time-slots that should be found by program
* time-frame - Longer time period in which we want to find empty slots in calendar, e.g. start from 24th Mar 8AM and end on 29th Mar 6PM (look for empty slots in entire week)

##Output:
* list of available time-slots
* information that it's not possible arrange meeting with everyone in the selected time-frame