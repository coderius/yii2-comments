<?php

$defaultAvatar = '/yii2-youtube-analizer/assets/31eba4b0/default/default-commentor-avatar.jpg';
?>

<div id="<?= $wrapperId; ?>" class="coderius comments">
  <h3 class="coderius dividing header"><?= $commentsBlockTitle; ?></h3>
  <?php if(!empty($commentsTree)): ?>
    <?php foreach($commentsTree as $comment): ?>
        <?= $this->render('_comment', compact(
            'comment',
            'commentReplyLinkTitle',
            'defaultAvatar',
            'avatarBaseUrl'
          )); ?>
    <?php endforeach; ?>
  <?php endif; ?>
  <?= $this->render('_form', compact(
      'encryptedData',
      'commentsFormButtonTitle',
      'commentsInputNameLabel',
      'commentsTextareaLabel',
      'commentsInputNamePlaceholder',
      'commentsTextareaPlaceholder'
    )); ?>
</div>
