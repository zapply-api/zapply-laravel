<?php

return [
    /**
     * Base URI
     *
     * This is the base URI defined for your device.
     */
    'base_uri' => env('ZAPPLY_BASE_URI'),

    /**
     * API Key
     *
     * This is the API key you created in Zapply dashboard.
     */
    'api_key' => env('ZAPPLY_API_KEY'),

    /**
     * Channel ID
     *
     * This is the ID of your WhatsApp Device created in your dashboard.
     */
    'channel_id' => env('ZAPPLY_CHANNEL_ID'),

    /**
     * Webhook Signature
     *
     * This is the signature used to verify the webhook request.
     */
    'webhook_signature' => env('ZAPPLY_WEBHOOK_SIGNATURE'),
];
