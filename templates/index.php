<?php
declare(strict_types=1);

use OCP\Util;

Util::addScript(OCA\TalkWidget\AppInfo\Application::APP_ID, OCA\TalkWidget\AppInfo\Application::APP_ID . '-dashboardTalk');
Util::addStyle(OCA\TalkWidget\AppInfo\Application::APP_ID, 'dashboard');

// Load dummy messages from initialState
$messages = \OCP\Util::getInitialState(OCA\TalkWidget\AppInfo\Application::APP_ID, 'dashboard-talk-messages') ?? [];
?>

<div id="talkwidget-dashboard-widget">
    <div id="talk-messages" style="height:250px; overflow-y:auto; border:1px solid #ddd; padding:8px; margin-bottom:10px; border-radius:6px; background:#fafafa;">
        <?php 
        $messages = \OCP\Util::getInitialState(OCA\TalkWidget\AppInfo\Application::APP_ID, 'dashboard-talk-messages') ?? [];
        foreach ($messages as $msg): ?>
            <div style="margin-bottom:8px;">
                <strong><?= htmlspecialchars($msg['id']) ?>:</strong>
                <?= htmlspecialchars($msg['title']) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="display:flex; gap:5px; align-items:center;">
        <select id="emoji-picker" style="padding:4px; border-radius:6px;">
            <option value="">😊</option>
            <option value="😀">😀</option>
            <option value="😂">😂</option>
            <option value="😍">😍</option>
            <option value="👍">👍</option>
            <option value="🙏">🙏</option>
        </select>

        <input type="text" id="talk-message-input" placeholder="Type a message..." style="flex:1; padding:6px; border:1px solid #ccc; border-radius:6px;" />

        <button id="talk-send-btn" style="padding:6px 10px; border:none; border-radius:6px; background:#0082c9; color:#fff;">
            Send
        </button>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const msgBox = document.getElementById('talk-messages');
    const input = document.getElementById('talk-message-input');
    const sendBtn = document.getElementById('talk-send-btn');
    const emojiPicker = document.getElementById('emoji-picker');

    if (!msgBox || !input || !sendBtn || !emojiPicker) return;

    // Emoji picker
    emojiPicker.addEventListener('change', () => {
        input.value += emojiPicker.value;
        emojiPicker.value = "";
    });

    // Send button
    sendBtn.addEventListener('click', () => {
        const text = input.value.trim();
        if (text !== "") {
            const div = document.createElement('div');
            div.innerHTML = "<strong>You:</strong> " + text;
            div.style.marginBottom = "8px";
            msgBox.appendChild(div);
            msgBox.scrollTop = msgBox.scrollHeight;
            input.value = "";
        }
    });
});
</script>
