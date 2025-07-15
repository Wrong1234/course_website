@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $product->name }}</h2>
                </div>
                <div class="card-body">
                    <p>{{ $product->description }}</p>
                    <h4 class="text-success">${{ number_format($product->price, 2) }}</h4>
                </div>
                <div class="card-footer">
                    {{-- Product inquiry WhatsApp button --}}
                    <x-whatsapp-button 
                        message="Hi! I'm interested in {{ $product->name }}. Can you provide more details about pricing and availability?"
                        button-text="Inquire About This Product"
                        button-class="btn btn-success btn-lg w-100" />
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            {{-- Sidebar with different WhatsApp options --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Need Help?</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        {{-- General inquiry --}}
                        <x-whatsapp-button 
                            message="Hello! I need general information about your products."
                            button-text="General Inquiry"
                            button-class="btn btn-outline-primary" />
                        
                        {{-- Technical support --}}
                        <x-whatsapp-button 
                            message="Hi! I need technical support for {{ $product->name }}."
                            button-text="Technical Support"
                            button-class="btn btn-outline-info" />
                        
                        {{-- Sales inquiry --}}
                        <x-whatsapp-button 
                            message="Hello! I'm interested in bulk pricing for {{ $product->name }}."
                            button-text="Bulk Pricing"
                            button-class="btn btn-outline-success" />
                    </div>
                </div>
            </div>
            
            {{-- Advanced card style --}}
            <x-whatsapp-advanced 
                style="card"
                message="Hi! I saw {{ $product->name }} on your website and would like to place an order."
                button-text="Place Order"
                variant="primary"
                size="lg"
                :show-message="true" />
        </div>
    </div>
</div>

{{-- Floating WhatsApp button for this product --}}
<x-whatsapp-advanced 
    style="floating"
    message="Hi! I'm viewing {{ $product->name }} and have some questions."
    button-text="Quick Chat"
    size="lg" />
@endsection