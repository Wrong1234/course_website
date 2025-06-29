{{-- resources/views/components/whatsapp-widget.blade.php --}}

<div class="whatsapp-widget">
    <div class="whatsapp-button" id="whatsappButton">
        <i class="fab fa-whatsapp"></i>
    </div>
    
    <div class="whatsapp-chat-box" id="whatsappChatBox" style="display: none;">
        <div class="chat-header">
            <div class="admin-info">
                <img src="{{ asset('images/admin-avatar.png') }}" alt="Admin" class="admin-avatar">
                <div>
                    <h5>Customer Support</h5>
                    <span class="status online">Online</span>
                </div>
            </div>
            <button class="close-chat" id="closeChatBox">&times;</button>
        </div>
        
        <div class="chat-body">
            <div class="message admin-message">
                <p>Hello! How can I help you today?</p>
            </div>
        </div>
        
        <div class="chat-footer">
            <form id="whatsappForm">
                <textarea id="messageInput" placeholder="Type your message..." rows="2"></textarea>
                <button type="submit">
                    <i class="fab fa-whatsapp"></i> Send
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.whatsapp-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}

.whatsapp-button {
    width: 60px;
    height: 60px;
    background: #25D366;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
    transition: all 0.3s ease;
}

.whatsapp-button:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(37, 211, 102, 0.6);
}

.whatsapp-button i {
    color: white;
    font-size: 24px;
}

.whatsapp-chat-box {
    position: absolute;
    bottom: 70px;
    right: 0;
    width: 300px;
    height: 400px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.chat-header {
    background: #075E54;
    color: white;
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.admin-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.admin-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.status.online {
    color: #4CAF50;
    font-size: 12px;
}

.close-chat {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
}

.chat-body {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
}

.message {
    margin-bottom: 10px;
}

.admin-message p {
    background: #F0F0F0;
    padding: 8px 12px;
    border-radius: 12px;
    margin: 0;
    display: inline-block;
}

.chat-footer {
    border-top: 1px solid #eee;
    padding: 15px;
}

.chat-footer form {
    display: flex;
    gap: 10px;
}

.chat-footer textarea {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 8px 12px;
    resize: none;
    outline: none;
}

.chat-footer button {
    background: #25D366;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .whatsapp-chat-box {
        width: 280px;
        height: 350px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const whatsappButton = document.getElementById('whatsappButton');
    const chatBox = document.getElementById('whatsappChatBox');
    const closeChatBox = document.getElementById('closeChatBox');
    const whatsappForm = document.getElementById('whatsappForm');
    const messageInput = document.getElementById('messageInput');

    // FIXED: Get admin number from config properly
    const adminNumber = @json(config('services.whatsapp.admin_number'));

    whatsappButton.addEventListener('click', function() {
        chatBox.style.display = chatBox.style.display === 'none' ? 'flex' : 'none';
    });

    closeChatBox.addEventListener('click', function() {
        chatBox.style.display = 'none';
    });

    whatsappForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (message) {
            // FIXED: Create WhatsApp URL with proper admin number
            const whatsappUrl = `https://wa.me/${adminNumber}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
            chatBox.style.display = 'none';
            messageInput.value = '';
        }
    });
});
</script>