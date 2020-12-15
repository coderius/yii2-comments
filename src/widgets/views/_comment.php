<?php

?>
<div class="comment">
    <a class="avatar">
        <img src="https://semantic-ui.com/images/avatar/small/matt.jpg">
    </a>
    <div class="content">
        <a class="author">Matt</a>
        <div class="metadata">
        <span class="date">Today at 5:42PM</span>
        </div>
        <div class="text">
        How artistic!
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