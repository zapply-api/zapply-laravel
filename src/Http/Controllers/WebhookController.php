<?php

namespace Zapply\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Zapply\Laravel\Events\WebhookHandled;
use Zapply\Laravel\Events\WebhookReceived;
use Zapply\Laravel\Http\Middleware\VerifyWebhookSignature;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    /**
     * Create a new WebhookController instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (config('zapply.webhook_signature')) {
            $this->middleware(VerifyWebhookSignature::class);
        }
    }

    /**
     * Handle a Zapply webhook call.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = 'handle' . Str::studly(str_replace('.', '_', $payload['event']));

        WebhookReceived::dispatch($payload);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            WebhookHandled::dispatch($payload);

            return $response;
        }

        return $this->missingMethod($payload);
    }

    /**
     * Handle successful calls on the controller.
     *
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function successMethod($parameters = [])
    {
        return new Response('Webhook Handled', 200);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function missingMethod($parameters = [])
    {
        return new Response();
    }
}
