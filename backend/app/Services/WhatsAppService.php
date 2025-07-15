<?php

// ================================================================
// WHATSAPP SERVICE WITH COMPREHENSIVE ERROR HANDLING
// ================================================================

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private $adminNumber;
    private $defaultMessage;
    private $errors = [];

    public function __construct()
    {
        $this->adminNumber = $this->validateAdminNumber();
        $this->defaultMessage = config('services.whatsapp.default_message', 'Hello! I need assistance.');
    }

    /**
     * Validate and retrieve admin number
     */
    private function validateAdminNumber(): ?string
    {
        $number = config('services.whatsapp.admin_number');
        
        if (empty($number)) {
            $this->addError('WhatsApp admin number is not configured');
            return null;
        }

        // Clean and validate phone number
        $cleanNumber = preg_replace('/[^0-9]/', '', $number);
        
        if (strlen($cleanNumber) < 10 || strlen($cleanNumber) > 15) {
            $this->addError('Invalid WhatsApp admin number format');
            return null;
        }

        return $cleanNumber;
    }

    /**
     * Generate WhatsApp chat URL with error handling
     */
    public function generateChatUrl(?string $message = null, bool $encoded = true): ?string
    {
        try {
            if (!$this->adminNumber) {
                $this->addError('Cannot generate URL: Admin number not available');
                return null;
            }

            $finalMessage = $message ?? $this->defaultMessage;
            
            if ($encoded) {
                $finalMessage = urlencode($finalMessage);
            }

            return "https://wa.me/{$this->adminNumber}?text={$finalMessage}";
            
        } catch (Exception $e) {
            $this->addError("Error generating WhatsApp URL: " . $e->getMessage());
            Log::error('WhatsApp URL generation failed', [
                'error' => $e->getMessage(),
                'message' => $message,
                'admin_number' => $this->adminNumber
            ]);
            return null;
        }
    }

    /**
     * Generate WhatsApp data array for views
     */
    public function getWhatsAppData(?string $message = null, string $buttonText = 'Chat on WhatsApp', string $buttonClass = 'btn btn-success'): array
    {
        return [
            'whatsAppUrl' => $this->generateChatUrl($message),
            'message' => $message ?? $this->defaultMessage,
            'buttonText' => $buttonText,
            'buttonClass' => $buttonClass,
            'isAvailable' => $this->isAvailable(),
            'errors' => $this->getErrors()
        ];
    }

    /**
     * Check if WhatsApp service is properly configured
     */
    public function isAvailable(): bool
    {
        return !empty($this->adminNumber) && empty($this->errors);
    }

    /**
     * Get all errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Add error to collection
     */
    private function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * Get error messages as string
     */
    public function getErrorsAsString(): string
    {
        return implode(', ', $this->errors);
    }
}