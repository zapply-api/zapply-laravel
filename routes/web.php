<?php

use Illuminate\Support\Facades\Route;
use Zapply\Laravel\Http\Controllers\WebhookController;

Route::post('webhook', [WebhookController::class, 'handleWebhook'])->name('webhook');
