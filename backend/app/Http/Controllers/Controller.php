<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\WhatsAppService;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Helper method to get WhatsApp data
     */
    protected function getWhatsAppData($message = null, $buttonText = null, $buttonClass = null)
    {
        try {
            $whatsAppService = new WhatsAppService();
            return $whatsAppService->getWhatsAppData(
                $message ?? 'Hello! I would like to know more about your services.',
                $buttonText ?? 'Contact us on WhatsApp',
                $buttonClass ?? 'btn btn-success'
            );
        } catch (\Exception $e) {
            return [
                'whatsAppUrl' => null,
                'isAvailable' => false,
                'errors' => ['WhatsApp service temporarily unavailable']
            ];
        }
    }

    /**
     * Helper method to render view with WhatsApp integration
     */
    protected function viewWithWhatsApp($view, $data = [], $message = null, $buttonText = null, $buttonClass = null)
    {
        $whatsAppData = $this->getWhatsAppData($message, $buttonText, $buttonClass);
        return view($view, array_merge($data, $whatsAppData));
    }
}