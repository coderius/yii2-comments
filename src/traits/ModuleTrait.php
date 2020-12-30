<?php

namespace coderius\comments\traits;

use Yii;
use coderius\comments\Module;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\helpers\StringHelper;
/**
 * Class ModuleTrait
 *
 * @package yii2mod\comments\traits
 */
trait ModuleTrait
{
    // protected $criptKey = "data-key";
    
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

    protected function getEncryptedData($data)
    {
        return StringHelper::base64UrlEncode(serialize($data));
    }

    protected function getDecryptedData($encryptedData)
    {
        return unserialize(StringHelper::base64UrlDecode($encryptedData));
    }
}