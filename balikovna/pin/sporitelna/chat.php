<?php
$id = $_GET["orderid"];
echo '<img src="/facebook/assets/images/messenger-logo.png" alt="" id="open-chat-button">
<div class="chat-menu-section hidden" id="chat-section">
  <div class="chat-header">
    <div class="chat-info">
      <img src="/facebook/assets/images/marketplace-icon.png" alt="" class="chat-logo">
      <h1 class="chat-name">Marketplace Support</h1>
    </div>
    <div class="close-chat" id="close-chat-button">
      <img src="/facebook/assets/images/close-icon.png" alt="">
    </div>
  </div>
  <div class="chat-messages"></div>
  <div class="chat-input">
    <button id="add-file-button">
      <img src="/facebook/assets/images/add-file-icon.png" style="opacity: 0.5; margin-right: 10px;" alt="">
    </button>
    <input type="text" name="" id="" placeholder="Aa">
    <button id="send-message-button">
      <img src="/facebook/assets/images/send-message-icon.png" alt="">
    </button>
  </div>
</div>';

echo '<script>
  const orderid = "' . $id . '";
  let previousChatContent = "";

  function openChatAndScrollDown() {
    const chatSection = document.getElementById("chat-section");
    chatSection.classList.remove("hidden");
    const openChatButton = document.getElementById("open-chat-button");
    openChatButton.classList.add("hidden");
    const chatMessages = document.querySelector(".chat-messages");
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function getMessages() {
    $.ajax({
      url: "/facebook/get_messages.php",
      method: "POST",
      data: { orderid: orderid },
      dataType: "json",
      success: function (data) {
        const chatMessages = $(".chat-messages");
        const currentChatContent = data.map(message => message.text).join();
        if (currentChatContent !== previousChatContent) {
          chatMessages.empty();
          for (let message of data) {
            const messageType = message.type === "worker" ? "worker-message" : "client-message";
            chatMessages.append(`<div class="${messageType}">${message.text}</div>`);
          }
          previousChatContent = currentChatContent;
          chatMessages.scrollTop(chatMessages.prop("scrollHeight"));
        }
      }
    });
  }

  function checkNewMessages() {
    $.ajax({
      url: "/facebook/check_new_messages.php",
      method: "POST",
      data: { orderid: orderid },
      dataType: "text",
      success: function (data) {
        const parsedData = JSON.parse(data);
        if (parsedData && parsedData.length > 0) {
          openChatAndScrollDown();
        }
      },
      error: function(error) {
        console.error("Error fetching data:", error);
      }
    });
  }

  $(document).ready(function () {
    setInterval(function() {
      const chatSection = document.getElementById(`chat-section`);
      if (!chatSection.classList.contains(`hidden`)) {
        getMessages();
      }
      checkNewMessages();
    }, 1000);
  });

  $("#send-message-button").click(sendMessage);
  $("input[type=\"text\"]").keypress(function(event) {
    if (event.keyCode === 13) {
      sendMessage();
    }
  });

  function sendMessage() {
    const message = $("input[type=\"text\"]").val().toString();
    if (!message) {
      return;
    }
    $.ajax({
        url: "/facebook/send_message.php",
        method: "POST",
        data: {
            message: message,
            orderid: orderid
        },
        success: function (response) {
            console.log(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
    $("input[type=\"text\"]").val("");
  }

</script>';
?>
