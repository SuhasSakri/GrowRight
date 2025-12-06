function initChatWidget() {
    const chatHTML = `
        <div id="aiChatWidget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
            <button id="chatToggle" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); border: none; color: white; font-size: 24px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">💬</button>
            <div id="chatBox" style="display: none; width: 350px; height: 500px; background: white; border-radius: 15px; box-shadow: 0 8px 30px rgba(0,0,0,0.2); position: absolute; bottom: 70px; right: 0; flex-direction: column;">
                <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 15px; border-radius: 15px 15px 0 0; font-weight: bold;">AI Assistant</div>
                <div id="chatMessages" style="flex: 1; overflow-y: auto; padding: 15px;"></div>
                <div style="padding: 10px; border-top: 1px solid #eee; display: flex; gap: 5px;">
                    <input type="text" id="chatInput" placeholder="Ask me anything..." style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 20px; outline: none; font-size: 14px;">
                    <button id="chatSend" style="width: 45px; height: 40px; background: #667eea; color: white; border: none; border-radius: 50%; cursor: pointer; flex-shrink: 0;">➤</button>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', chatHTML);

    const chatToggle = document.getElementById('chatToggle');
    const chatBox = document.getElementById('chatBox');
    const chatInput = document.getElementById('chatInput');
    const chatSend = document.getElementById('chatSend');
    const chatMessages = document.getElementById('chatMessages');

    chatToggle.onclick = () => chatBox.style.display = chatBox.style.display === 'none' ? 'flex' : 'none';

    async function sendMessage() {
        const message = chatInput.value.trim();
        if (!message) return;

        addMessage('user', message);
        chatInput.value = '';
        addMessage('ai', 'Thinking...');

        try {
            const response = await fetch('openai_chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message })
            });
            const data = await response.json();
            chatMessages.lastChild.remove();
            addMessage('ai', data.success ? data.message : '❌ ' + data.error);
        } catch (error) {
            chatMessages.lastChild.remove();
            addMessage('ai', '❌ Connection error');
        }
    }

    function addMessage(sender, text) {
        const msgDiv = document.createElement('div');
        msgDiv.style.cssText = `margin-bottom: 10px; padding: 10px; border-radius: 10px; ${sender === 'user' ? 'background: #667eea; color: white; margin-left: 20px; text-align: right;' : 'background: #f0f0f0; margin-right: 20px;'}`;
        msgDiv.textContent = text;
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    chatSend.onclick = sendMessage;
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initChatWidget);
} else {
    initChatWidget();
}
