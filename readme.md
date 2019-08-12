<p align="center">
        <img src="https://raw.githubusercontent.com/hoseinz3/simpleStore/hoseinz3-patch-1/10.jpg" width="250" alt="PHP Insights">
          <p align="center">
    <strong>This is a <a href="https://phpinsights.com">Takeaway.com</a> code challenge that I named it Road Runner </strong>.
  </p>
</p>

**Road Runner** was created by [Mohammad Hosein abedi](https://github.com/hoseinz3), and is a fault tolerance email-service.
It sends an email by the high available provider at the moment with the super simple syntax.

## Overview
- Once an email provider failed, It would be removed from the available providers.
- A simple JSON API for sending emails
- Simple Command-Line tools for sending emails
- Support multiple recipients
- Have a light-weight [Vue-Application](https://github.com/hoseinz3/ui-road-runner)
- Brilliant performance (send email asynchronously with queuing technique)
- Have 95.8 pts in code-quality from [PHP Insights](https://github.com/nunomaduro/phpinsights)
### Providers
- [SendGrid](https://sendgrid.com)
- [PostMark](https://postmarkapp.com)
### Technologies
- Framework: [Laravel](https://github.com/laravel/laravel).
- Database: [Mysql](https://www.mysql.com/).
- Test: [PHPUnit](https://github.com/sebastianbergmann/phpunit) & [Mockery](https://github.com/mockery/mockery).
- Queue: [Redis](https://redis.io/).
- Deployment: [Docker](https://www.docker.com/).
- Code Quality: [PHP Insights](https://github.com/nunomaduro/phpinsights)

## 🚀 Quick start
**Important:** If you have not the .env file in the root folder, you must copy or rename the .env.example to .env

**Configuring a database**

.env file
```
DB_HOST=mysql #name of Mysql Services in the docker-compose.yml file
```
### Installation
For using Road Runner you have a very easy task to do. Just run below command:

```./start.sh```

It builds the containers and runs commands that Road Runner needs to be up and running.

**Important:** The default port is ```8088```

