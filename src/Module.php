<?php

namespace coderius\comments;

use Yii;
use yii\web\GroupUrlRule;

class Module extends \yii\base\Module
{
    /** @var string module name */
    public static $moduleName = 'comments';

    /** @var string|null */
    public $userIdentityClass = null;

    // public $controllerNamespace = 'coderius\comments\controllers';

    public function init()
    {
        parent::init();

        \Yii::configure($this, require __DIR__ . '/config/main.php');

        //иначе ломает консольные комманды
        if (Yii::$app instanceof yii\web\Application) {
            if ($this->userIdentityClass === null) {
                $this->userIdentityClass = \Yii::$app->getUser()->identityClass;
            }
        }

    }

    /**
     * Adds UrlManager rules.
     *
     * @param Application $app the application currently running
     */
    public function addUrlManagerRules($app)
    {
        

        
    }

    /**
     * @return static
     */
    public static function selfInstance()
    {
        return \Yii::$app->getModule(static::$moduleName);
    }

    /**
     * Get default model classes.
     */
    public function getDefaultModels()
    {
        
    }

    public function model($name)
    {
        
    }
}
