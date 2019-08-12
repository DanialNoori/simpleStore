<p align="center">
        <img src="https://raw.githubusercontent.com/hoseinz3/simpleStore/hoseinz3-patch-1/10.jpg" width="250" alt="Road Runner">
          <p align="center">
    This is a <a href="https://takeaway.com">Takeaway.com</a> code challenge that I named it<strong> Road Runner </strong>.
  </p>
</p>

**Road Runner** was created by [Mohammad Hosein abedi](https://github.com/hoseinz3), and is a fault tolerance email-service.
It sends an email using the available providers at each moment.

## Overview
- Once an email provider fails, It would be removed from the available providers.
- It has a simple JSON API for sending emails
- It also has a simple command-Line tool for sending emails
- Supports multiple recipients
- Has a light-weight [Vue-Application](https://github.com/hoseinz3/ui-road-runner)
- It has a Brilliant performance (sends emails asynchronously with queuing technique)
- Has a 95.8 pts in code-quality from [PHP Insights](https://github.com/nunomaduro/phpinsights)

<p align="center">
        <img src="https://raw.githubusercontent.com/hoseinz3/simpleStore/hoseinz3-patch-1/insights.png" width="550" alt="PHP Insights">
</p>

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
**Important Note:** If you don't have the .env file in the root folder, you must copy or rename the .env.example to .env

**Configuring the database**

.env file
```
DB_HOST=mysql #name of Mysql Services in the docker-compose.yml file
```
### Installation
In order to use Road Runner you only have one simple task to do. Just run the command below:

`./start.sh`

It builds the containers and runs commands that Road Runner needs to be up and running.

**Important:** The default port is `8088`

## About code architecture

All codes that are related to implementation of mailers are placed in the `Takeaway` folder. there are two types of classes in this folder:

- `Transport` this is responsible for sending request to mailer's API. it's not coupled to `Guzzle` implementation so it's easy to test.
- MailerTransport such as `SendGridTransport` provides the required for their API.

`TransportInterface` that `Transport` implemented it, tells us what the functionality of every mailer is. 
```php
<?php

namespace App\Takeaway\Transport;

use App\Takeaway\MessageInterface;

interface TransportInterface
{
    public function send(MessageInterface $message): string ;
    public function healthCheck(): bool ;

}
```

every mailer has to extend `Transport`, for example:

```php
<?php

namespace App\Takeaway\Transport;

use App\Takeaway\MessageInterface;
use Psr\Http\Message\ResponseInterface;

class MailGunTransport extends Transport
{
    protected $endpoint = '';

    protected $healthCheckEndPoint = '';
    
    protected function getPayload(MessageInterface $message): array
    {
        return [];
    }

    protected function getHeaders(): array
    {
        return [];
    }

    protected function getTrackingId(ResponseInterface $response)
    {   
        // parse the $response and return tracking_id that came from mailer
    }
}

```
#### Queue
`SendEmailJob` is responsible for sending an email in the background. it needs two arguments, `MessageInterface` and `$emailId`. it chooses one mailer then it sends an email with that provider and inserts the name of it in the `emails` table. 

#### How its failover works
there is a table named `mailers` that contains mailers' name and availability.
there is a command named `MailerAvailabilityChecker` that runs every minute and checks the availability of all mailers and updates `availability` field in the `mailers` table.

when an email is sent to the `SendEmailJob`, it selects from available mailers in random order.



