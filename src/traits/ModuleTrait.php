<?php

namespace coderius\comments\traits;

use Yii;
use coderius\comments\Module;

/**
 * Class ModuleTrait
 *
 * @package yii2mod\comments\traits
 */
trait ModuleTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return Module::selfInstance();
    }

    /**
     * Get default model classes.
     */
    public function getCommentService()
    {
        return Yii::$container->get('coderius\comments\components\services\CommentService');
    }
}