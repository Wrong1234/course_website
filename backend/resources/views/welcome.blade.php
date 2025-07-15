@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Welcome to Our Site</h1>
            
            {{-- METHOD 1: Using basic component --}}
            <div class="mb-3">
                <h5>Basic WhatsApp Button:</h5>
                <x-whatsapp-button />
            </div>
            
            {{-- METHOD 2: Using component with custom parameters --}}
            <div class="mb-3">
                <h5>Custom WhatsApp Button:</h5>
                <x-whatsapp-button 
                    message="Hello! I'm interested in your services"
                    button-text="Get Quote on WhatsApp"
                    button-class="btn btn-primary btn-lg" />
            </div>
            
            {{-- METHOD 3: Using advanced component --}}
            <div class="mb-3">
                <h5>Advanced WhatsApp Components:</h5>
                
                {{-- Floating button --}}
                <x-whatsapp-advanced 
                    style="floating"
                    message="Hello! I need support"
                    size="lg" />
                
                {{-- Card style --}}
                <x-whatsapp-advanced 
                    style="card"
                    message="Hello! I want to inquire about your products"
                    button-text="Contact Sales"
                    variant="primary"
                    :show-message="true" />
            </div>
            
            {{-- METHOD 4: Using variables passed from controller --}}
            @if(isset($whatsAppUrl) && $isAvailable)
                <div class="mb-3">
                    <h5>Using Controller Variables:</h5>
                    <a href="{{ $whatsAppUrl }}" 
                       target="_blank" 
                       class="{{ $buttonClass ?? 'btn btn-success' }}">
                        <i class="fab fa-whatsapp me-2"></i>
                        {{ $buttonText ?? 'Chat on WhatsApp' }}
                    </a>
                </div>
            @endif
            
            {{-- METHOD 5: Using helper functions --}}
            @if(isWhatsAppAvailable())
                <div class="mb-3">
                    <h5>Using Helper Functions:</h5>
                    <a href="{{ getWhatsAppUrl('Hello from helper function!') }}" 
                       target="_blank" 
                       class="btn btn-info">
                        <i class="fab fa-whatsapp me-2"></i>
                        Helper Function Button
                    </a>
                </div>
            @endif
            
            {{-- METHOD 6: Conditional rendering with error handling --}}
            <div class="mb-3">
                <h5>With Error Handling:</h5>
                @php
                    $whatsAppData = getWhatsAppData(
                        'Hello! I found your website and would like to learn more.',
                        'Learn More on WhatsApp',
                        'btn btn-outline-success'
                    );
                @endphp
                
                @if($whatsAppData['isAvailable'])
                    <a href="{{ $whatsAppData['whatsAppUrl'] }}" 
                       target="_blank" 
                       class="{{ $whatsAppData['buttonClass'] }}">
                        <i class="fab fa-whatsapp me-2"></i>
                        {{ $whatsAppData['buttonText'] }}
                    </a>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        WhatsApp chat is currently unavailable.
                        @if(!empty($whatsAppData['errors']))
                            <small class="d-block mt-1">
                                Errors: {{ implode(', ', $whatsAppData['errors']) }}
                            </small>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
   <a href="{{ getWhatsAppUrl('Need help?') }}"
   target="_blank"
   class="whatsapp-floating-button">
   💬 Chat on WhatsApp
</a>

<style>
.whatsapp-floating-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #25D366;
    color: white;
    padding: 12px 16px;
    border-radius: 50px;
    font-weight: bold;
    text-decoration: none;
    z-index: 9999;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}
</style>
</div>
@endsection
