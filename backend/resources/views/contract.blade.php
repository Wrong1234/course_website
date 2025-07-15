@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Contact Us</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Get in Touch</h5>
                            <p>We'd love to hear from you! Choose your preferred way to contact us:</p>
                            
                            <div class="contact-options">
                                {{-- WhatsApp contact --}}
                                <x-whatsapp-advanced 
                                    style="card"
                                    message="Hello! I'd like to get in touch with your team."
                                    button-text="Chat on WhatsApp"
                                    variant="success"
                                    :show-icon="true"
                                    :show-message="false" />
                                
                                {{-- Different inquiry types --}}
                                <div class="mt-4">
                                    <h6>Quick Contact Options:</h6>
                                    <div class="d-grid gap-2">
                                        <x-whatsapp-button 
                                            message="Hello! I have a sales inquiry."
                                            button-text="Sales Inquiry"
                                            button-class="btn btn-success" />
                                        
                                        <x-whatsapp-button 
                                            message="Hi! I need customer support."
                                            button-text="Customer Support"
                                            button-class="btn btn-primary" />
                                        
                                        <x-whatsapp-button 
                                            message="Hello! I'm interested in partnership opportunities."
                                            button-text="Partnership Inquiry"
                                            button-class="btn btn-info" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            {{-- Traditional contact form --}}
                            <h5>Send us a Message</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </form>
                            
                            <div class="mt-3">
                                <small class="text-muted">
                                    Or for faster response, use WhatsApp above!
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection