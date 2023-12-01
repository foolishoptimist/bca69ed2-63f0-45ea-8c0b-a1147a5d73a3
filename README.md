# ACER coding challenge

## Usage
After cloning the repo, checkout branch feature/assessment-reports
The following commands will run the app and tests respectively:
- docker-compose run app
- docker-compose run test

## Assumptions
I've setup the CLI to allow directly calling command with inline parameters for efficiency.
The user input behavior falls back to the specified behavior of prompting the user for the parameters when they are not entered.
I attempted to keep the data retrieval/querying somewhat similar to Eloquent ORM as I would assume at somepoint a database would be used.
In that event, the tests would be refactored to use test data.

## Notes
I added id to fillable which I normally wouldn't do, but I was running short on time and wanted to get the final bit running.

I tried adding Github Actions, but while I've had them on projects before, I've never set it up before.

In the end, this was all I had time for in the 3 hour time frame for this challenge.



