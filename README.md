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

Updated Expected output for tests to match data. Also added colon for consistency.

Assumed in the event of multiple assessments in the data that the report should output all. Would probably normally add an optional parameter to specify an assessmentId.

