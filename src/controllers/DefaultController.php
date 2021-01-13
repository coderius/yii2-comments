<?php

namespace coderius\comments\controllers;

use coderius\comments\components\services\CreateCommentService;
use coderius\comments\models\CommentFormModel;
use Yii;
use yii\web\Controller;
use coderius\comments\components\events\CommentEvent;

/**
 * Class DefaultController.
 */
class DefaultController extends Controller
{
    const EVENT_BEFORE_CREATE = 'beforeCreate';

    const EVENT_AFTER_CREATE = 'afterCreate';
    
    private $createCommentService;

    public function __construct($id,
        $module,
        CreateCommentService $createCommentService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->createCommentService = $createCommentService;
        
    }

    // public function actionCreateComment($encryptedData)
    // {
    //     Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_JSON;
    //     if (Yii::$app->request->isAjax) {
    //         return [
    //                 'status' => 'success',
    //                 'data' => 'ok',
    //             ];
            
    //     }
    // }

    public function actionCreateComment()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->getResponse();
        $response->format = \yii\web\Response::FORMAT_JSON;
        
        $formModel = Yii::createObject(
            [
                'class' => CommentFormModel::class,
                'scenario' => CommentFormModel::SCENARIO_CREATE,
            ]
        );
        
        if ($request->isAjax) {
            $formModel->load($request->post(), '');
            $isValid = $formModel->validate();

            //Event EVENT_BEFORE_CREATE
            $this->beforeCommentCreate(['scenario' => $formModel->getScenario()]);

            if ($isValid) {
                $dto = $this->createCommentService->createComment($formModel);
                
                //Event EVENT_AFTER_CREATE
                $this->afterCommentCreate([
                    'id' => $dto->id,
                    'materialId' => $dto->materialId,
                    'scenario' => $formModel->getScenario(),
                ]);
                
                return [
                    'status' => 'success',
                    'data' => $dto,
                ];
            } else {
                return [
                    'status' => 'validation-error',
                    'data' => $formModel->getErrors(),
                ];
            }
        }
    }

    protected function beforeCommentCreate($params){
        $event = $this->createEvent($params);
        Yii::$app->trigger(self::EVENT_BEFORE_CREATE, $event);
    }

    protected function afterCommentCreate($params){
        $event = $this->createEvent($params);
        Yii::$app->trigger(self::EVENT_AFTER_CREATE, $event);

    }

    protected function createEvent($params){
        $params = array_merge(['class' => CommentEvent::class], $params);
        return Yii::createObject($params);
    }

    public function actionLike()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->getResponse();
        $response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'status' => 'active',
            'data' => 0,
        ];
    }
}
