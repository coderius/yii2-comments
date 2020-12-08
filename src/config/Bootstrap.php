<?php

namespace coderius\comments\config;

use coderius\comments\Module;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;
use yii\di\Instance;

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

        $this->addDependencies();
    }

    private function addDependencies(){
        $container = \Yii::$container;
        
        // $container->setSingleton('queryCommentsFinderRepository',
        //     ['class' => 'coderius\comments\repositories\QueryCommentsFinderRepository'],
        //     [Instance::of('yii\db\Query')]
        // );

        // $container->setSingleton('coderius\comments\repositories\Interfaces\CommentsFinderRepositoryInterface',
        //     'queryCommentsFinderRepository'
        // );

        // $container->setSingleton('coderius\comments\services\CommentsService',
        //     [],
        //     [
        //         Instance::of('coderius\comments\repositories\QueryCommentsFinderRepository'),
        //         Instance::of('coderius\comments\repositories\DAOCommentsCRUDRepository'),
        //     ]
        // );

        

    }

}
