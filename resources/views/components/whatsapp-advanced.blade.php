@props([
    'message' => null,
    'buttonText' => 'Chat on WhatsApp',
    'style' => 'button', // button, floating, card, inline
    'size' => 'md', // sm, md, lg
    'variant' => 'success', // success, primary, info, warning
    'showIcon' => true,
    'showMessage' => false
])

@php
    $whatsAppData = getWhatsAppData($message, $buttonText, '');
    $isAvailable = $whatsAppData['isAvailable'];
    $whatsAppUrl = $whatsAppData['whatsAppUrl'];
    
    // Dynamic classes based on props
    $baseClasses = match($style) {
        'floating' => 'position-fixed bottom-0 end-0 m-4 btn-floating',
        'card' => 'card border-success',
        'inline' => 'd-inline-block',
        default => 'btn'
    };
    
    $sizeClasses = match($size) {
        'sm' => $style === 'button' ? 'btn-sm' : 'small',
        'lg' => $style === 'button' ? 'btn-lg' : 'large',
        default => ''
    };
    
    $variantClasses = match($variant) {
        'primary' => $style === 'button' ? 'btn-primary' : 'text-primary',
        'info' => $style === 'button' ? 'btn-info' : 'text-info',
        'warning' => $style === 'button' ? 'btn-warning' : 'text-warning',
        default => $style === 'button' ? 'btn-success' : 'text-success'
    };
    
    $finalClasses = trim("$baseClasses $sizeClasses $variantClasses");
@endphp

@if($isAvailable && $whatsAppUrl)
    @if($style === 'card')
        <div class="{{ $finalClasses }}">
            <div class="card-body text-center">
                @if($showIcon)
                    <i class="fab fa-whatsapp fa-2x text-success mb-2"></i>
                @endif
                <h6 class="card-title">{{ $buttonText }}</h6>
                @if($showMessage && $message)
                    <p class="card-text small text-muted">{{ Str::limit($message, 50) }}</p>
                @endif
                <a href="{{ $whatsAppUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn {{ $variantClasses }} btn-{{ $size }}">
                    Start Chat
                </a>
            </div>
        </div>
    @elseif($style === 'floating')
        <a href="{{ $whatsAppUrl }}" 
           target="_blank" 
           rel="noopener noreferrer"
           class="{{ $finalClasses }} shadow-lg rounded-circle p-3"
           style="z-index: 1050;"
           title="{{ $buttonText }}"
           aria-label="Open WhatsApp chat">
            @if($showIcon)
                <i class="fab fa-whatsapp fa-lg"></i>
            @else
                <span class="small">Chat</span>
            @endif
        </a>
    @else
        <a href="{{ $whatsAppUrl }}" 
           target="_blank" 
           rel="noopener noreferrer"
           class="{{ $finalClasses }}"
           title="{{ $buttonText }}"
           aria-label="Open WhatsApp chat">
            @if($showIcon)
                <i class="fab fa-whatsapp me-2"></i>
            @endif
            {{ $buttonText }}
        </a>
    @endif
@else
    {{-- Error state --}}
    <div class="whatsapp-unavailable">
        @if($style === 'card')
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                    <h6 class="card-title">Chat Unavailable</h6>
                    <p class="card-text small text-muted">WhatsApp chat is temporarily unavailable</p>
                </div>
            </div>
        @else
            <button class="btn btn-secondary {{ $sizeClasses }}" disabled>
                <i class="fas fa-exclamation-triangle me-2"></i>
                Chat Unavailable
            </button>
        @endif
    </div>
@endif