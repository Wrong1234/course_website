<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;


class WhatsAppErrorHandler
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Test WhatsApp service availability
            $whatsAppService = app(WhatsAppService::class);
            $isAvailable = $whatsAppService->isAvailable();
            
            // Share availability status with all views
            View::share('whatsappAvailable', $isAvailable);
            
            if (!$isAvailable) {
                // Log the error for monitoring
                Log::warning('WhatsApp service unavailable', [
                    'errors' => $whatsAppService->getErrors(),
                    'url' => $request->url(),
                    'user_agent' => $request->userAgent()
                ]);
            }
            
        } catch (\Exception $e) {
            // If service completely fails, share false status
            View::share('whatsappAvailable', false);
            Log::error('WhatsApp service error in middleware', [
                'error' => $e->getMessage(),
                'url' => $request->url()
            ]);
        }
        
        return $next($request);
    }
}