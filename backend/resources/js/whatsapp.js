// resources/js/whatsapp.js

function sendToWhatsApp(message) {
    fetch('/whatsapp-url', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        window.open(data.url, '_blank');
    })
    .catch(error => console.error('Error:', error));
}

// Usage
document.getElementById('whatsapp-btn').addEventListener('click', function() {
    const message = document.getElementById('message-input').value;
    sendToWhatsApp(message);
});