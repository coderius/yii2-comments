<?php
use coderius\comments\widgets\captcha\CaptchaWidget;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$js = new JsExpression('



');

$this->registerJs(
  $js,
  \yii\web\View::POS_READY,
  'verifyCode_reload'
);

?>

<?= Html::beginForm($action = Url::to(['/comments/default/create-comment']), $method = 'post', $options = ['class' => 'coderius form reply']); ?>
<!-- hidden -->
  <?= Html::hiddenInput('parentId'); ?>
  <?= Html::hiddenInput('level'); ?>
  <?= Html::hiddenInput('encryptedData', $encryptedData); ?>
<!-- input name -->
  <?= Html::beginTag('div', $options = ['class' => 'field']); ?>
      <?= Html::label($commentsInputNameLabel.' *'); ?>
      <?= Html::input('text', 'commentorFirstName', null, ['placeholder' => $commentsInputNamePlaceholder]); ?>
      <?= Html::beginTag('div', $options = ['class' => 'field-validation-error-wrapper']); ?><?= Html::endTag('div'); ?>
  <?= Html::endTag('div'); ?>
<!-- textarea -->
  <?= Html::beginTag('div', $options = ['class' => 'field']); ?>
      <?= Html::label($commentsTextareaLabel.' *'); ?>
      <?php //echo Html::textarea('commentText', '', ['placeholder' => $commentsTextareaPlaceholder]);?>
      <?= TinyMce::widget([
            'name' => 'commentText',
            'id' => 'tinyeditor',
            'options' => ['rows' => 6, 'placeholder' => $commentsTextareaPlaceholder],
            'language' => \Yii::$app->language ? preg_replace('/-[\w]+/s', '', Yii::$app->language) : null, //ru-RU to ru
            'clientOptions' => [
              'branding' => false,
              'selector' => 'textarea',
              'menubar' => false,
              'content_style' => 'body { line-height: 0.2; }',
              'setup' => new JsExpression("function (editor) {
                  editor.on('change', function () {
                      tinymce.triggerSave();
                  });
              }"),
                'plugins' => [
                    'advlist autolink lists link charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste image imagetools nonbreaking',
                    'codesample',
                ],
                'toolbar' => 'undo redo | codesample | link image | bold italic | styleselect | bullist numlist outdent indent | alignleft aligncenter alignright alignjustify',
                'codesample_dialog_height' => new JsExpression('$( window ).height()'), //for codesample
                'codesample_languages' => new JsExpression("[
                    {text: 'PHP', value: 'php'},
                    {text: 'HTML/XML', value: 'markup'},
                    {text: 'JavaScript', value: 'javascript'},
                    {text: 'CSS', value: 'css'}
                ]"),
                'nonbreaking_force_tab' => true, //разрешить табы
                'image_advtab' => true,
                'image_title' => true,
            ],
          ]);
      ?>
      <?= Html::beginTag('div', $options = ['class' => 'field-validation-error-wrapper']); ?><?= Html::endTag('div'); ?>
  <?= Html::endTag('div'); ?>

  <!-- Captcha -->
  <?= Html::beginTag('div', $options = ['class' => 'field']); ?>
    <?= Html::label("{$commentsCaptchaLabel} *"); ?>
    <?= Html::beginTag('div', $options = ['style' => 'display: flex;align-items: center;']); ?>
    
    <!-- Captcha reload button-->
    <p class="verifyCode_reload" style="margin:0">
      <i class="icon sync"></i>
    </p>
    
      <?= CaptchaWidget::widget([
              'name' => 'verifyCode',
              'captchaAction' => 'comments/default/captcha',
              'imageOptions' => [
                'class' => 'captchaImage',
              ],
              'options' => [
                'style' => 'margin-left: 14px',
                'placeholder' => $commentsCaptchaPlaceholder,
              ],
              'clientOptions' => [
                'elemSelectorRefresh' => '.verifyCode_reload',
                'beforeRefresh' => new JsExpression('
                  function($img, $elem){$elem.children("i").toggleClass("loading");}
                
                '),
                'afterRefreshSuccess' => new JsExpression('
                  function($img, $elem){$elem.children("i").toggleClass("loading");}
                
                '),
              ],
          ]);
      ?>
    <?= Html::endTag('div'); ?> 
    <?= Html::beginTag('div', $options = ['class' => 'field-validation-error-wrapper']); ?><?= Html::endTag('div'); ?>
  <?= Html::endTag('div'); ?>
  

<!-- button submit-->
  <?= Html::beginTag('div', $options = ['class' => 'coderius blue labeled submit icon button']); ?>
      <?= Html::beginTag('i', ['class' => 'icon edit']); ?><?= Html::endTag('i'); ?>
      <?= $commentsFormButtonTitle; ?>
  <?= Html::endTag('div'); ?>

<!-- button cancel-->
  <?= Html::beginTag('div', $options = ['class' => 'coderius labeled cancel icon button', 'style' => 'visibility:hidden']); ?>
      <?= Html::beginTag('i', ['class' => 'icon undo']); ?><?= Html::endTag('i'); ?>
      <?= $commentsFormButtonCancelTitle; ?>
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

<?php

?>