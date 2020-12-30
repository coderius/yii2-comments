<?php

namespace coderius\comments\controllers;

use coderius\comments\components\services\CreateCommentService;
use coderius\comments\models\CommentFormModel;
use Yii;
use yii\web\Controller;

/**
 * Class DefaultController.
 */
class DefaultController extends Controller
{
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

//         $decrypt = Yii::$app->getSecurity()->decryptByKey(utf8_decode($encryptedData), \coderius\comments\Module::selfInstance()->id);
        
// $decrypt = \yii\helpers\Json::decode($decrypt);

        if ($request->isAjax) {
            $formModel->load($request->post(), '');
            $isValid = $formModel->validate();

            if ($isValid) {
                $dto = $this->createCommentService->createComment($formModel);
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
}
