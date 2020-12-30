<?php

namespace coderius\comments\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii2mod\behaviors\PurifyBehavior;

class CommentFormModel extends Model{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $commentorFirstName;
    public $commentText;
    public $materialId;
    public $parentId;
    public $introducedAvatar;
    public $encryptedData;
    
    /**
     * {@inheritdoc}
     */
     public function rules()
     {
         return [
             [['commentorFirstName', 'commentText'], 'required'],
             [['commentorFirstName'], 'string', 'max' => 255],
             [['materialId', 'parentId', 'introducedAvatar', 'encryptedData'], 'safe']
         ];
     }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['commentorFirstName', 'commentText', 'materialId', 'parentId', 'introducedAvatar', 'encryptedData'];
        $scenarios[self::SCENARIO_UPDATE] = ['commentorFirstName', 'commentText', 'materialId', 'parentId', 'encryptedData'];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'commentorFirstName' => Yii::t('coderius.comments.messages', 'Commentor First Name'),
            'commentText' => Yii::t('coderius.comments.messages', 'Comment Text'),
        ];
    }
}