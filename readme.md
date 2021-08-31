# Assignment

## Description
A small PHP assignment meant to cover a wide area of skills. It's meant as a Best-Effort assignment as we will care more about your journey, rather than the end results.

## Requirements

Create a small PHP service that exposes a RESTful API over CRUD operations on a model.

Given the `employee` model, containing:

`name`

`position`

`superior` the link to another employee with a management position

`startDate`

`endDate`

#### We need to be able to:

1. Save, update, delete and read an employee
2. Find all the child employees of a parent employee with a management position
3. Find all employees, filtered by a specific position
4. Make sure that the above requirements are tested properly both with negative and positive scenarios
5. Have a docker image that can run the service
6. Have a docker compose that can run all the dependencies that the service requires in order to work(I.E a database)

## Evaluation

We look for:
1. The way you structure your test code and how you write it
2. Your train of thought
3. Your decision-making
3. Attention to details
4. The code quality (code standards, best practices, design patterns, etc)
5. The way you write docs
6. Performance

## Suggestions

Please don't reinvent the wheel. The internet has everything you need. We care about how you solve puzzles and how you
use the legos to build the end product.

You can use whichever 3rd party libraries you see fit to get the job done.

## Going in for the kill

If you really want to showoff your skills and impress us, you can do so by using any of the following:

1. Laravel (with Lumen)
2. Codeception
3. HTTP/2 on by default

## Deadline

It has to be submitted within 24hours since the moment you received this assignment.

Don't worry about the tight deadline, this assignment is a best effort approach, not a "get all things done no matter
what".

## Deliverable

Create a public personal github repo where you commit and push this assignment.