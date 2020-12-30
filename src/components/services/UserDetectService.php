<?php
namespace coderius\comments\components\services;

use yii\base\BaseObject;
use Yii;

class UserDetectService extends BaseObject{

    public function __construct($config = [])
    {
        //

        parent::__construct($config);
    }

    public static function getUserIpString(){
        $request = Yii::$app->request;
        return $request->getUserIP();
    }

}