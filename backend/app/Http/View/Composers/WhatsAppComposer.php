<?php
namespace App\Http\View\Composers;

use App\Services\WhatsAppService;
use Illuminate\View\View;

class WhatsAppComposer
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function compose(View $view)
{
    $data = $this->whatsAppService->getWhatsAppData();

    $view->with([
        'whatsAppUrl' => $data['whatsAppUrl'] ?? null,
        'message' => $data['message'] ?? 'Hello!',
        'buttonText' => $data['buttonText'] ?? 'Chat on WhatsApp',
        'buttonClass' => $data['buttonClass'] ?? 'btn btn-success',
        'isAvailable' => $data['isAvailable'] ?? false,
        'whatsAppErrors' => $data['errors'] ?? [],
    ]);
  }
}