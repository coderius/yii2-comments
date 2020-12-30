<?php


?>

<div id="<?= $wrapperId; ?>" class="coderius comments">
  <h3 class="coderius dividing header"><?= $commentsBlockTitle; ?></h3>
  <?php foreach($commentsTree as $comment): ?>
      <?= $this->render('_comment', compact(
          'comment',
          'commentReplyLinkTitle',
          'defaultAvatar',
          'avatarBaseUrl'
        )); ?>
  <?php endforeach; ?>
  <?= $this->render('_form', compact(
      'encryptedData',
      'commentsFormButtonTitle',
      'commentsInputNameLabel',
      'commentsTextareaLabel',
      'commentsInputNamePlaceholder',
      'commentsTextareaPlaceholder'
    )); ?>
</div>
