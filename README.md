# Rest Hero

![logo](assets/marca.png)

*Simple Personal Rest Client to debug REST API's **on termial***


## Instalation

    - Clone this project
    - Get composer at https://getcomposer.org

Install dependences

```
$ composer install
```

# Commands

## Flow
Flow is a sequence of cases environment, where you can write your requests, and responses treatments

Create a new flow is simple

```
./newflow FlowName
```

or

```
php newflow.php FlowName
```

A new folder will be created inside **Tests** folder with a simple default structure

## Case

Case is a simple unity of request, your function is make a request to a endpoint and receive the response.
You choose what make with it, check if return is valid, or simple say a "ok"

Create a new flow is like this

```
newcase FlowName CaseName
```

or

```
php newcase.php FlowName CaseName
```

All case has to be created with a numeric sequence  starting the name of the case, if you use the newcase command it'll be done automatically. This define the sequence of execution when you execute all the cases.

## How it works

You can execute only a case of flow

Let's say I only want to execute the 01-oauth-case.php of FooFlow:

```
./exec FooFlow 01
```

or

```
php exec.php FooFlow 01
```

But if you make a flow of cases, attached each other, you can execute a group of cases, like this:

    - FooFlow
            - 01-oauth-teste.php
            - 02-user-login.php
            - 03-get-profile.php

```
./exec FooFlow
```

or

```
php exec.php FooFlow
```

All 3 cases will be executed in order

## Tips

    - Files started with _ are ignored
    - There some core classes made to help with response and log, check there!
    - Helper's folder exists to make classes to help with data generation, despite this we add Faker Lib too
    - At test-log folder is logger all responses that use Log Class  

## Fake Data

Use github.com/fzaninotto/Faker to generate fake data on cases

