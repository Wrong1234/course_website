<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class TestWhatsAppService extends Command
{
    protected $signature = 'whatsapp:test {--message=Test message from console}';
    protected $description = 'Test WhatsApp service functionality';

    public function handle()
    {
        $this->info('Testing WhatsApp Service...');
        $this->newLine();
        
        try {
            $service = new WhatsAppService();
            
            // Test service availability
            $this->info('1. Testing service availability...');
            $isAvailable = $service->isAvailable();
            $this->line('   Status: ' . ($isAvailable ? 'Available' : 'Not Available'));
            
            if (!$isAvailable) {
                $errors = $service->getErrors();
                $this->error('   Errors: ' . implode(', ', $errors));
            }
            
            $this->newLine();
            
            // Test URL generation
            $this->info('2. Testing URL generation...');
            $message = $this->option('message');
            $url = $service->generateChatUrl($message);
            
            if ($url) {
                $this->line('   Generated URL: ' . $url);
                $this->info('   ✓ URL generation successful');
            } else {
                $this->error('   ✗ URL generation failed');
                $this->error('   Errors: ' . $service->getErrorsAsString());
            }
            
            $this->newLine();
            
            // Test data generation
            $this->info('3. Testing data generation...');
            $data = $service->getWhatsAppData($message, 'Test Button', 'btn btn-test');
            
            $this->table(
                ['Property', 'Value'],
                [
                    ['URL', $data['whatsAppUrl'] ?? 'null'],
                    ['Message', $data['message']],
                    ['Button Text', $data['buttonText']],
                    ['Button Class', $data['buttonClass']],
                    ['Available', $data['isAvailable'] ? 'Yes' : 'No'],
                    ['Errors', empty($data['errors']) ? 'None' : implode(', ', $data['errors'])]
                ]
            );
            
            $this->newLine();
            
            // Configuration check
            $this->info('4. Configuration check...');
            $adminNumber = config('services.whatsapp.admin_number');
            $defaultMessage = config('services.whatsapp.default_message');
            $enabled = config('services.whatsapp.enabled');
            
            $this->table(
                ['Setting', 'Value', 'Status'],
                [
                    ['Admin Number', $adminNumber ? '***' . substr($adminNumber, -4) : 'Not Set', $adminNumber ? '✓' : '✗'],
                    ['Default Message', $defaultMessage ?? 'Not Set', $defaultMessage ? '✓' : '✗'],
                    ['Enabled', $enabled ? 'Yes' : 'No', $enabled ? '✓' : '✗']
                ]
            );
            
            $this->newLine();
            
            if ($isAvailable) {
                $this->info('✓ WhatsApp service is working correctly!');
                return 0;
            } else {
                $this->error('✗ WhatsApp service has issues that need to be resolved.');
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error('Fatal error testing WhatsApp service: ' . $e->getMessage());
            return 1;
        }
    }
}