<?php

use yii\helpers\Html;
use yii\helpers\Url;

// var_dump($defaultAvatar);die;
?>
<div class="comment">
    <a class="avatar">
        <!-- <img src="https://semantic-ui.com/images/avatar/small/matt.jpg"> -->
        <?php if(null === $comment->introducedAvatar): ?>
        <?= Html::img($defaultAvatar, ['alt' => $comment->introducedName]); ?>
        <?php else: ?>
        <?= Html::img($avatarBaseUrl . $comment->introducedAvatar, ['alt' => $comment->introducedName]); ?>
        <?php endif; ?>

    </a>
    <div class="content">
        <a class="author"><?= $comment->introducedName; ?></a>
        <div class="metadata">
        <span class="date"><?= $comment->createdAt; ?></span>
        </div>
        <div class="text">
        <?= $comment->content; ?>
        </div>
        <div class="actions">
        <a class="reply"><?= $commentReplyLinkTitle; ?></a>
        </div>
    </div>
    <?php if (!empty($comment->children)) : ?>
        <?php foreach($comment->children as $children): ?>
            <div class="comments">
            <?= $this->render('_comment', [
                    'comment' => $children,
                    'commentReplyLinkTitle' => $commentReplyLinkTitle,
                ]); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>