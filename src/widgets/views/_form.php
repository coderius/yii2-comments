<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?= Html::beginForm($action = Url::to(['/comments/default/create-comment']), $method = 'post', $options = ['class' => 'coderius form reply']); ?>
<!-- hidden -->
  <?= Html::hiddenInput('parentId'); ?>
  <?= Html::hiddenInput('encryptedData', $encryptedData); ?>
<!-- input name -->
  <?= Html::beginTag('div', $options = ['class' => 'field']); ?>
      <?= Html::label($commentsInputNameLabel); ?>
      <?= Html::input('text', 'commentorFirstName', null, ['placeholder' => $commentsInputNamePlaceholder]); ?>
      <?= Html::beginTag('div', $options = ['class' => 'field-validation-error-wrapper']); ?><?= Html::endTag('div'); ?>
  <?= Html::endTag('div'); ?>
<!-- textarea -->
  <?= Html::beginTag('div', $options = ['class' => 'field']); ?>
      <?= Html::label($commentsInputNameLabel); ?>
      <?= Html::textarea('commentText', '', ['placeholder' => $commentsTextareaPlaceholder]); ?>
      <?= Html::beginTag('div', $options = ['class' => 'field-validation-error-wrapper']); ?><?= Html::endTag('div'); ?>
  <?= Html::endTag('div'); ?>

<!-- button -->
  <?= Html::beginTag('div', $options = ['class' => 'coderius blue labeled submit icon button']); ?>
      <?= Html::beginTag('i', ['class' => 'icon edit']); ?><?= Html::endTag('i'); ?>
      <?= $commentsFormButtonTitle; ?>
  <?= Html::endTag('div'); ?>

<?= Html::endForm(); ?>

<!-- <form class="coderius form reply" action="<?= Url::to(['/comments/default/create-comment']); ?>" method="post">
    <div class="field">
      <label><?= $commentsInputNameLabel; ?></label>
      <input type="text" name="commentor-first-name" placeholder="<?= $commentsInputNamePlaceholder; ?>">
    </div>
    <div class="field">
      <label><?= $commentsTextareaLabel; ?></label>
      <textarea name="comment-text" placeholder="<?= $commentsTextareaPlaceholder; ?>"></textarea>
    </div>
    <div class="coderius blue labeled submit icon button">
      <i class="icon edit"></i> <?= $commentsFormButtonTitle; ?>
    </div>
</form> -->