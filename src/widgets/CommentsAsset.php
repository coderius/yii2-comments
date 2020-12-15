<?php

namespace coderius\comments\widgets;

use yii\web\AssetBundle;

/**
 * Class CommentAsset
 *
 * @package yii2mod\comments
 */
class CommentsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = (__DIR__ . '/assets');

    /**
     * @inheritdoc
     */
    public $js = [
        'js/comments.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/comments.css',
        'css/form.css',
        'css/buttons.css',
        'css/icons.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => true
    ];
}