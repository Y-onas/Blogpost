<?php if (isset($messageBox) && $messageBox): ?>
  <div class="message-box active <?= htmlspecialchars($messageType ?? '') ?>" id="messageBox">
    <div class="message-content">
      <span class="close-message">&times;</span>
      <h3><?= htmlspecialchars($messageTitle ?? 'Message') ?></h3>
      <p><?= htmlspecialchars($messageText) ?></p>
    </div>
  </div>
<?php endif; ?>
