<!-- 
     $customStyles .= "
    <link href='./assets/global/plugins/typeahead/typeahead.css' rel='stylesheet' type='text/css' />
    ";
    $customScript .= "
    <script src='views/chat_bot/assets/algo.js'></script>
    <script src='views/chat_bot/assets/script.js'></script>
    ";
    include "views/chat_bot/chatbox.php";
 -->

<link rel="stylesheet" href="Chat_Bot/assets/style.css">

<a href="#open_chatbot">
    <div class="bot-icon">
        <img src="Chat_Bot/assets/img/chatbot.png" alt="">
    </div>
</a>

<div class="chatbox-wrap bg-white" id="chatbotBox" style="height: 480px; width: 330px; display: none;">
    <div class="chatbox-content">
        <div class="chatbox-header bg-blue">
            <div class="bot-icon">
                <img src="Chat_Bot/assets/img/chatbot.png" alt="">
                <span class="active"></span>
            </div>
            <div>
                <h4 style="font-weight: 500; margin: 0;">InterlinkIQ Bot</h4>
                <h6 style="margin: 0;">Online</h6>
            </div>
            <div class="font-white">
                <button type="button" class="chatbox-close"></button>
            </div>
        </div>
        <div class="chatbox-body">
            <div class="messages-wrap">
                <div class="messages">
                    <div class="post in">
                        <img class="avatar" alt="" src="Chat_Bot/assets/img/chatbot.png">
                        <div class="post-body">
                            <span class="name">InterlinkIQ Bot</span>
                            <div class="message">
                                Hi Almario 🖐
                            </div>
                            <div class="message">
                                What may I help you? 😊
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="chatbotComposeMessage" class="chatbox-footer">
            <div style="width: 100%;">
                <textarea style="resize: none; border: none;" name="message" class="form-control" rows="1"
                    placeholder="Write a message..."></textarea>
            </div>
            <button type="submit" class="btn btn-link btn-lg" style="padding: 0 10px 0 0;">
                <i class="fa fa-send"></i>
            </button>
        </form>
    </div>
</div>
