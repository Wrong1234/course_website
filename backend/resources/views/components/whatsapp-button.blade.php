@if(!empty($whatsAppUrl) && !empty($isAvailable))
    <a href="{{ $whatsAppUrl }}" 
       target="_blank" 
       rel="noopener noreferrer"
       class="{{ $buttonClass }}"
       title="Chat with us on WhatsApp"
       aria-label="Open WhatsApp chat">
        <i class="fab fa-whatsapp me-2" aria-hidden="true"></i>
        {{ $buttonText }}
    </a>
@else
    {{-- Error state or fallback --}}
    <div class="whatsapp-error">
        @if(!empty($errors))
            <small class="text-muted">
                <i class="fas fa-exclamation-triangle me-1"></i>
                WhatsApp temporarily unavailable
            </small>
        @else
            <button class="btn btn-secondary" disabled>
                <i class="fab fa-whatsapp me-2"></i>
                {{ $buttonText }}
            </button>
        @endif
    </div>
@endif