# Zapply for Laravel

<p align="center">
<a href="https://github.com/zapply-api/zapply-laravel/actions"><img src="https://github.com/zapply-api/zapply-laravel/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/zapply/zapply-laravel"><img src="https://img.shields.io/packagist/dt/zapply/zapply-laravel" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/zapply/zapply-laravel"><img src="https://img.shields.io/packagist/v/zapply/zapply-laravel" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/zapply/zapply-laravel"><img src="https://img.shields.io/packagist/l/zapply/zapply-laravel" alt="License"></a>
</p>


## Getting Started

First install Zapply for Laravel via the Composer package manager:

```bash
composer require zapply/zapply-laravel
```

Next, you must load the service provider:

```php   
// config/app.php
'providers' => [
    // ...
    Zapply\Laravel\ZapplyServiceProvider::class,
],
```

Next, you should configure your application's .env file:

```env
ZAPPLY_BASE_URI=your-zapply-base-uri
ZAPPLY_API_KEY=your-zapply-api-key
ZAPPLY_CHANNEL_ID=your-zapply-channel-id
```

Finally, you may use the Resend facade to access Zapply API:
```php
use Zapply\Laravel\Facades\Zapply;

Zapply::chat('552199999999')->sendMessage([
    'recipient_type' => 'individual',
    'type' => 'text',
    'message' => [
        'body' => 'Hello World!',
    ]
])
````

## Sending via Laravel Notifications

In every model you wish to be notifiable via WhatsApp, you must add a number property to that model accessible through a routeNotificationForZapply method:

```php
class User extends Eloquent
{
    use Notifiable;

    public function routeNotificationForZapply()
    {
        return $this->number;
    }
}
```

The number should be in format: Country Code + Area Code + Phone Number, for example: 552199999999.

You may now tell Laravel to send notifications to WhatsApp in the via method:

```php
use Illuminate\Notifications\Notification;
use Zapply\Laravel\Zapply;
use Zapply\Laravel\Messages\TextMessage;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [Zapply::class];
    }

    public function toZapply($notifiable)
    {
        return TextMessage::create('Your invoice has been paid!');
    }
}
```

### Available Message Types

```php
use Zapply\Laravel\Messages\TextMessage;
use Zapply\Laravel\Messages\ImageMessage;
use Zapply\Laravel\Messages\AudioMessage;
use Zapply\Laravel\Messages\DocumentMessage;
use Zapply\Laravel\Messages\VideoMessage;

TextMessage::create('Hello World!');

ImageMessage::create('https://example.com/image.jpg', 'Caption!');

AudioMessage::create('https://example.com/audio.mp3');

DocumentMessage::create('https://example.com/document.pdf', 'Caption!');

VideoMessage::create('https://example.com/video.mp4', 'Caption!');
```

## Handling Webhooks

Zapply can notify your application of a variety of events via webhooks. By default, a route that points to Zapply's webhook controller is automatically registered by the Zapply service provider. This controller will handle all incoming webhook requests.

### Webhooks and CSRF Protection

Since Zapply webhooks need to bypass Laravel's CSRF protection, be sure to list the URI as an exception in your application's App\Http\Middleware\VerifyCsrfToken middleware or list the route outside of the web middleware group:

```php
protected $except = [
    'zapply/*',
];
```

### Defining Webhook Event Handlers

You may handle webhhok events by listening to the following events that are dispatched:

* Zapply\Laravel\Events\WebhookReceived
* Zapply\Laravel\Events\WebhookHandled

Both events contain the full payload of Zapply webhook. For example, if you wish to handle the message webhook, you may register a listener that will handle the event:

```php
<?php
 
namespace App\Listeners;
 
use Zapply\Laravel\Events\WebhookReceived;
 
class ZapplyEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['event'] === 'message') {
            // Handle the incoming event...
        }
    }
}
```

### Verifying Webhook Signatures
To secure your webhooks, you may use Zapply's webhook signatures. For convenience, we already included a middleware which validates that the incoming webhook request is valid.

To enable webhook verification, ensure that the ZAPPLY_WEBHOOK_SIGNATURE environment variable is set in your application's .env file. The webhook secret may be retrieved from your Zapply account dashboard.
