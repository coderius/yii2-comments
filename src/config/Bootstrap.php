<?php

namespace coderius\comments\config;

use coderius\comments\Module;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;
use yii\di\Instance;
use Yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        // var_dump($app instanceof WebApplication);die;
        $module = Module::selfInstance();

        if ($app instanceof WebApplication) {
            $module->addUrlManagerRules($app);
        } elseif ($app instanceof ConsoleApplication) {
            $module->controllerNamespace = 'coderius\comments\commands';
        }
        $this->addAliases();
        $this->addDependencies();
    }

    private function addAliases(){
        
        Yii::setAlias('@images', dirname(__DIR__), '/assets/images');
        Yii::setAlias('@avatarsWeb', dirname(dirname(__DIR__)).'/src/assets/avatars/');
        Yii::setAlias('@avatarsPath', dirname(__DIR__), '/assets/images');
    }

    private function addDependencies(){
        $container = \Yii::$container;
        
        // $container->setSingleton('queryCommentsFinderRepository',
        //     ['class' => 'coderius\comments\repositories\QueryCommentsFinderRepository'],
        //     [Instance::of('yii\db\Query')]
        // );

        $container->set(
            'coderius\comments\components\repo\CommentRepoInterface',
            'coderius\comments\components\repo\CommentRepoQuery'
        );

        $container->set(
            'coderius\comments\components\repo\CreateCommentRepoInterface',
            'coderius\comments\components\repo\CreateCommentRepoDAO'
        );

        // $container->setSingleton('coderius\comments\services\CommentsService',
        //     [],
        //     [
        //         Instance::of('coderius\comments\repositories\QueryCommentsFinderRepository'),
        //         Instance::of('coderius\comments\repositories\DAOCommentsCRUDRepository'),
        //     ]
        // );

        

    }

}
