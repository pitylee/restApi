# Initialize the repository

You can download the repo as a zip, or **clone** on your workspace if you have the proper git setup:

```
git clone git@github.com:pitylee/restApi.git
```

And then pull the laradock submodule, in some cases with older version of git this is needed:

```
git submodule update --init --recursive
```

# Dependencies

While a stable internet connection is needed, you may have to install **Docker (Desktop)** and **Docker Compose** if you don't have already installed.
If you still have to install, please follow the official docs to do so [here](https://docs.docker.com/desktop/#download-and-install) and [here](https://docs.docker.com/compose/install/).

# Before we begin

## Give exec permission to laradock

If you are not already in `laradock` directory, first change the current dir where you have the project:

```
cd /path/to/project/dir/
```

To give executive permission, run the following command:

```
chmod +x ./start
```

You have to copy the .env file from the root, to the laradock submodule's directory:
```
cp .env.docker ./laradock/.env
```

# Usage

## Start docker environment

For short usage on Mac and Linux, you can run via the file which contains the commands:

```
./start 
```

This will run the `docker-compose` commands, or you can rule them manually, via running in the terminal of your preference:

```
docker-compose up -d --build nginx mysql redis php-worker

docker-compose exec --user=laradock workspace bash
```



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