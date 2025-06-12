<!-- Load CSS -->
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/animate.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/style.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/custom.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/material-icons.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/iCheck/green.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/datepicker/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/select2/select2-bootstrap.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/selectize/selectize.bootstrap3.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/quill/quill.snow.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/switchery/switchery.css" rel="stylesheet">

<style>
	.select2-dropdown{
		z-index: 3051;
	}
	.select2-container {
		width: 100%!important;
	}
	div.selectize-dropdown {
		z-index: 9999;
	}
	.datepicker.dropdown-menu {
		z-index: 9999 !important;
	}
	div.quill-wrapper {
        min-height: 6em;
        border: 1px solid #ccc;
        background-color: white;
    }
    div.quill-wrapper div.toolbar {
        border-bottom: 1px solid #ccc;
    }

	.floating-button {
		position: fixed;
		bottom: 20px;
		right: 20px;
		background-color: #1ab394;
		color: white;
		border-radius: 50%;
		width: 50px;
		height: 50px;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
		font-size: 24px;
		cursor: pointer;
		transition: background-color 0.3s ease;
		z-index: 9999 !important; /* Ensures the button is on top of all elements */
	}

	.floating-button:hover {
		background-color: #179b77;
	}
	
	/* chatbot Button, 11 Jun 2025 - Ferry */
	.chatbot-button {
		position: fixed;
		bottom: 20px;
		right: 80px;
		background-color: #075e54;
		color: white;
		border-radius: 50%;
		width: 50px;
		height: 50px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
		cursor: pointer;
		z-index: 9999;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
	}
	.chatbot-button:hover {
		background-color: #20c05a;
	}

	/* Chatbox Popup */
	.chatbox {
		position: fixed;
		/* top: auto;  */
		/* left: auto;  */

		bottom: 85px;
		right: 20px;
		width: 320px;
		height: 460px;
		background-color: #f0f0f0;
		border-radius: 10px;
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
		display: flex;
		flex-direction: column;
		overflow: hidden;
		z-index: 9998;
		font-family: "Segoe UI", sans-serif;
	}

	.chatbox-header {
		background-color: #075e54;
		color: white;
		padding: 12px 15px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-weight: bold;
	}

	.chatbox-header .close-chat {
		cursor: pointer;
	}

	.chatbox-body {
		flex: 1;
		padding: 10px;
		overflow-y: auto;
		background-color: #e5ddd5;
		display: flex;
		flex-direction: column;
		gap: 10px;
	}

	.chatbox-footer {
		display: flex;
		border-top: 1px solid #ccc;
		background: #fff;
		padding: 8px;
	}
	.chatbox-footer textarea {
		flex: 1;
		resize: none;
		border: none;
		padding: 8px 10px;
		border-radius: 20px;
		background-color: #f1f1f1;
		font-size: 14px;
		outline: none;
		line-height: 1.4;
		max-height: 100px; /* batas maksimal tinggi */
		overflow-y: auto;
	}

	.chatbox-footer button {
		border: none;
		background: none;
		color: #075e54;
		font-size: 20px;
		padding: 0 10px;
		cursor: pointer;
	}

	/* Message Style */
	.msg {
		max-width: 75%;
		padding: 8px 12px;
		border-radius: 7px;
		font-size: 14px;
		line-height: 1.4;
		word-wrap: break-word;
	}
	.msg.bot {
		align-self: flex-start;
		background-color: #fff;
		color: #000;
		border-radius: 7px 7px 7px 0;
	}
	.msg.user {
		align-self: flex-end;
		background-color: #dcf8c6;
		color: #000;
		border-radius: 7px 7px 0 7px;
	}

	/* Typing animation */
	.typing-indicator {
		display: flex;
		gap: 4px;
		align-items: center;
	}
	.typing-indicator .dot {
		width: 6px;
		height: 6px;
		background-color: #555;
		border-radius: 50%;
		animation: blink 1.4s infinite;
	}
	.typing-indicator .dot:nth-child(2) {
		animation-delay: 0.2s;
	}
	.typing-indicator .dot:nth-child(3) {
		animation-delay: 0.4s;
	}
	@keyframes blink {
		0%, 80%, 100% { opacity: 0; }
		40% { opacity: 1; }
	}

</style>

<!-- Button untuk Filter Floating-->
<div class="floating-button" id="btnFilterFloating" style="display: none" data-toggle="tooltip" data-placement="top" title="Filter">
	<i class="fa fa-filter"></i>
</div>


<!-- Floating Chat Button -->
<div class="chatbot-button" id="btnChatbot" data-toggle="tooltip" data-placement="left" title="Chatbot">
  <i class="fa fa-comment"></i>
</div>

<!-- Chatbot Popup -->
<div class="chatbox d-none" id="chatPopup">
  <div class="chatbox-header">
    <span>Chatbot (Beta)</span>
    <i class="fa fa-times close-chat" id="closeChat"></i>
  </div>
  <div class="chatbox-body" id="chatBody">
	<div class="msg bot">
		Hai! 👋 Saya di sini untuk membantu. Silakan tulis pertanyaan Anda.
	</div>

  </div>
  <div class="chatbox-footer">
    <!-- <input type="text" id="userInput" placeholder="Tulis pesan..." /> -->
	<textarea id="userInput" placeholder="Tulis pesan..." rows="1"></textarea>
    <button id="sendBtn"><i class="fa fa-paper-plane"></i></button>
  </div>
</div>