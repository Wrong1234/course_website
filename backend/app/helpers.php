<?php

use App\Services\WhatsAppService;

if (!function_exists('getWhatsAppUrl')) {
    function getWhatsAppUrl(?string $message = null): ?string {
        try {
            $service = app(WhatsAppService::class);
            return $service->generateChatUrl($message);
        } catch (\Exception $e) {
            // \Log::error('WhatsApp helper function failed', ['error' => $e->getMessage()]);
            return null;
        }
    }
}

if (!function_exists('getWhatsAppData')) {
    function getWhatsAppData(?string $message = null, string $buttonText = 'Chat on WhatsApp', string $buttonClass = 'btn btn-success'): array {
        try {
            $service = app(WhatsAppService::class);
            return $service->getWhatsAppData($message, $buttonText, $buttonClass);
        } catch (\Exception $e) {
            // \Log::error('WhatsApp data helper failed', ['error' => $e->getMessage()]);
            return [
                'whatsAppUrl' => null,
                'message' => $message ?? 'Hello!',
                'buttonText' => $buttonText,
                'buttonClass' => $buttonClass,
                'isAvailable' => false,
                'errors' => ['Service unavailable'],
            ];
        }
    }
}

if (!function_exists('isWhatsAppAvailable')) {
    function isWhatsAppAvailable(): bool {
        try {
            $service = app(WhatsAppService::class);
            return $service->isAvailable();
        } catch (\Exception $e) {
            return false;
        }
    }
}
