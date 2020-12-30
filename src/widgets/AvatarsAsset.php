<?php

namespace coderius\comments\widgets;

use yii\web\AssetBundle;

/**
 * Class CommentAsset
 *
 * @package yii2mod\comments
 */
class AvatarsAsset extends AssetBundle
{
    // const SOURCE = (__DIR__ . '/assets/images');
    
    /**
     * @inheritdoc
     */
    public $sourcePath = (__DIR__ . '/assets/images/avatars');

    public $defaultAvatar = 'default/default-commentor-avatar.jpg';



    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => true
    ];

    public static function publicate(){
        $self = \Yii::createObject([
            'class' => self::class,
        ]);
        $am = \Yii::$app->assetManager;
        $self->publish($am);
        return $self;
    }

    public function getDefaultAvatarUrl(){
        return "{$this->baseUrl}/{$this->defaultAvatar}";
    }

    public function getRegularAvatarUrl(){
        return "{$this->baseUrl}/regular/";
    }

}