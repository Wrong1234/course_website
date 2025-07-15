@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>WhatsApp Integration Debug</h2>
            
            @php
                $whatsAppData = getWhatsAppData('Debug test message');
                $service = app(\App\Services\WhatsAppService::class);
            @endphp
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Service Status</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>Available:</strong></td>
                                    <td>
                                        @if($whatsAppData['isAvailable'])
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>URL Generated:</strong></td>
                                    <td>
                                        @if($whatsAppData['whatsAppUrl'])
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Errors:</strong></td>
                                    <td>
                                        @if(empty($whatsAppData['errors']))
                                            <span class="badge bg-success">None</span>
                                        @else
                                            <span class="badge bg-warning">{{ count($whatsAppData['errors']) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Admin Number:</strong></td>
                                    <td>
                                        @if(config('services.whatsapp.admin_number'))
                                            <span class="badge bg-info">Configured</span>
                                        @else
                                            <span class="badge bg-danger">Not Set</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Generated Data</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>WhatsApp URL:</strong></td>
                                    <td>
                                        @if($whatsAppData['whatsAppUrl'])
                                            <code class="small">{{ Str::limit($whatsAppData['whatsAppUrl'], 50) }}</code>
                                        @else
                                            <span class="text-muted">Not generated</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Message:</strong></td>
                                    <td><code class="small">{{ $whatsAppData['message'] }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Button Text:</strong></td>
                                    <td><code class="small">{{ $whatsAppData['buttonText'] }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Button Class:</strong></td>
                                    <td><code class="small">{{ $whatsAppData['buttonClass'] }}</code></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(!empty($whatsAppData['errors']))
                <div class="alert alert-danger mt-3">
                    <h6>Errors Found:</h6>
                    <ul class="mb-0">
                        @foreach($whatsAppData['errors'] as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="mt-4">
                <h5>Test Components</h5>
                <div class="row">
                    <div class="col-md-4">
                        <h6>Basic Component:</h6>
                        <x-whatsapp-button message="Test message from debug page" />
                    </div>
                    <div class="col-md-4">
                        <h6>Advanced Component:</h6>
                        <x-whatsapp-advanced 
                            style="card"
                            message="Debug test message"
                            button-text="Debug Chat"
                            :show-message="true" />
                    </div>
                    <div class="col-md-4">
                        <h6>Helper Function:</h6>
                        @if(isWhatsAppAvailable())
                            <a href="{{ getWhatsAppUrl('Helper function test') }}" 
                               target="_blank" 
                               class="btn btn-primary">
                                Helper Test
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>
                                Helper Not Available
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <h5>Configuration Check</h5>
                <div class="card">
                    <div class="card-body">
                        <pre><code>Config Values:
Admin Number: {{ config('services.whatsapp.admin_number') ? 'Set (***' . substr(config('services.whatsapp.admin_number'), -4) . ')' : 'Not Set' }}
Default Message: {{ config('services.whatsapp.default_message', 'Not Set') }}
Enabled: {{ config('services.whatsapp.enabled', false) ? 'Yes' : 'No' }}

Environment Variables:
WHATSAPP_ADMIN_NUMBER: {{ env('WHATSAPP_ADMIN_NUMBER') ? 'Set' : 'Not Set' }}
WHATSAPP_DEFAULT_MESSAGE: {{ env('WHATSAPP_DEFAULT_MESSAGE') ? 'Set' : 'Not Set' }}
WHATSAPP_ENABLED: {{ env('WHATSAPP_ENABLED', 'Not Set') }}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection