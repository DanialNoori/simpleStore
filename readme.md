<p align="center">
        <img src="https://raw.githubusercontent.com/hoseinz3/simpleStore/hoseinz3-patch-1/10.jpg" width="250" alt="Road Runner">
          <p align="center">
    This is a <a href="https://takeaway.com">Takeaway.com</a> code challenge that I named it<strong> Road Runner </strong>.
  </p>
</p>

**Road Runner** was created by [Mohammad Hosein abedi](https://github.com/hoseinz3), and is a fault tolerance email-service.
It sends an email by the high available provider at the moment.

## Overview
- Once an email provider failed, It would be removed from the available providers.
- A simple JSON API for sending emails
- Simple Command-Line tools for sending emails
- Support multiple recipients
- Have a light-weight [Vue-Application](https://github.com/hoseinz3/ui-road-runner)
- Brilliant performance (send email asynchronously with queuing technique)
- Have 95.8 pts in code-quality from [PHP Insights](https://github.com/nunomaduro/phpinsights)

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
**Important:** If you have not the .env file in the root folder, you must copy or rename the .env.example to .env

**Configuring a database**

.env file
```
DB_HOST=mysql #name of Mysql Services in the docker-compose.yml file
```
### Installation
For using Road Runner you have a very easy task to do. Just run below command:

`./start.sh`

It builds the containers and runs commands that Road Runner needs to be up and running.

**Important:** The default port is `8088`

## About code architecture

All codes that related to implementation of mailers are placed in the `Takeaway` folder. there are two types of classes in this folder:

- `Transport` this is responsible for sending request to mailer's API. it's not coupled to `Guzzle` implementation so it's easy to test.
- MailerTransport such as `SendGridTransport` should provides right data that their API needs.

`TransportInterface` that `Transport` implemented it, tells us what is the functionality of every mailer. 
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

every mailer have to extends `Transport` for example:

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
`SendEmailJob` is responsible for sending an email in background. it needs two argumans, `MessageInterface` and `$emailId`. it choose one mailer then it sends an email with that and insert name of it to the `emails` table. 

#### How its failover works
there is a table named `mailers` that contains mailer's name and availability.
there is a command named `MailerAvailabilityChecker` that runs every minute and check availability of all mailers and update `availability` field in `mailers` table.

when an email would be sent in the `SendEmailJob` it select between available mailers in random order.



