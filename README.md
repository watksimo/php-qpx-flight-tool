# php-qpx-flight-tool

## MVP Definition

**Input**
* Start date
* Origin
* List of destinations
* Duration at each destination (in days)
* Final location

**Output/Storage**
* Cheapest path between all destinations matching all criteria

**Process**

1. Determines every possible order visiting all locations, starting and finishing at the input locations and departing on the given date.

1. Checks the cost of each path, storing only the cheapest at each step.

1. Returns and stores the cheapest overall cost between all destinations matching all criteria in a database.

## Future Additions
* Price alerting.
  * Cheapest flight between each destination also output/stored.
* Accept start date as range, determines everything above for every possible date in range.
