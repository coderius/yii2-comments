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

    private $container;

    // public $controllerNamespace = 'coderius\comments\controllers';

    public function init()
    {
        parent::init();

        \Yii::configure($this, static::getConfig());
        $this->registerTranslations();
        //иначе ломает консольные комманды
        if (Yii::$app instanceof yii\web\Application) {
            if ($this->userIdentityClass === null) {
                $this->userIdentityClass = \Yii::$app->getUser()->identityClass;
            }
        }

        $this->container = Yii::$container;

    }

    protected static function getConfig(){
        $conf = require __DIR__ . '/config/main.php';
        return $conf;
    }

    protected function registerTranslations()
    {
        // var_dump(static::getConfig()['components']['i18n']['translations']);
        Yii::$app->i18n->translations = array_merge(Yii::$app->i18n->translations,static::getConfig()['components']['i18n']['translations']);
    }

    /**
     * Adds UrlManager rules.
     *
     * @param Application $app the application currently running
     */
    public function addUrlManagerRules($app)
    {
        $app->urlManager->addRules([new GroupUrlRule([
            'prefix' => $this->id,
            'rules' => require __DIR__ . '/config/_routes.php',
        ])], true);

    }

    /**
     * @return static
     */
    public static function selfInstance()
    {
        return \Yii::$app->getModule(static::$moduleName);
    }

    public function model($name)
    {
        
    }
}
