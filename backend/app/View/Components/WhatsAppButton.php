<?php
namespace App\View\Components;

use App\Services\WhatsAppService;
use Illuminate\View\Component;

class WhatsAppButton extends Component
{
    public $whatsAppUrl;
    public $message;
    public $buttonText;
    public $buttonClass;
    public $isAvailable;
    public $errors;

    public function __construct(
        ?string $message = null,
        string $buttonText = 'Chat on WhatsApp',
        string $buttonClass = 'btn btn-success'
    ) {
        $whatsAppService = new WhatsAppService();
        $data = $whatsAppService->getWhatsAppData($message, $buttonText, $buttonClass);
        
        $this->whatsAppUrl = $data['whatsAppUrl'];
        $this->message = $data['message'];
        $this->buttonText = $data['buttonText'];
        $this->buttonClass = $data['buttonClass'];
        $this->isAvailable = $data['isAvailable'];
        $this->errors = $data['errors'];
    }

    public function render()
    {
        return view('components.whatsapp-button');
    }
}