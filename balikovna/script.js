const openChatButton = document.getElementById("open-chat-button");
const chatSection = document.getElementById("chat-section");
const closeChatButton = document.getElementById("close-chat-button")
const chatMessages = document.querySelector('.chat-messages');

openChatButton.onclick = async function() {
    chatSection.classList.remove('hidden');
    openChatButton.classList.add('hidden');
    chatMessages.scrollTop = chatMessages.scrollHeight;
    
    // Ждем 100 миллисекунд, чтобы браузер успел отобразить содержимое чата перед прокруткой
    await new Promise(resolve => setTimeout(resolve, 100));
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

closeChatButton.onclick = function() {
    chatSection.classList.add('hidden')
    openChatButton.classList.remove('hidden')
}

window.addEventListener("load", function () {
    const preloader = document.getElementById("preloader");
    preloader.classList.add("hidden");
  });
  