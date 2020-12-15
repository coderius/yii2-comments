<?php

use Yii;

?>

<div class="ui comments">
  <h3 class="ui dividing header"><?= $commentsBlockTitle; ?></h3>
  <?php foreach($commentsTree as $comment): ?>
      <?= $this->render('_comment', [
          'comment' => $comment,
          'commentReplyLinkTitle' => $commentReplyLinkTitle,
        ]); ?>
  <?php endforeach; ?>
  <?= $this->render('_form', [
      'commentsFormButtonTitle' => $commentsFormButtonTitle,
    ]); ?>
</div>
