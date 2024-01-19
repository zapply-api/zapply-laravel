<?php

namespace Zapply\Laravel\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VerifyWebhookSignature
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function handle($request, Closure $next)
    {

        $signature = $request->header('Webhook-Signature');
        $configured = config('zapply.webhook_signature');

        if ($signature !== $configured) {
            throw new AccessDeniedHttpException('Invalid signature.');
        }

        return $next($request);
    }
}
