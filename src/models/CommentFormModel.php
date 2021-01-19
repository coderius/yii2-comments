<?php

namespace coderius\comments\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use coderius\comments\components\behaviors\PurifyBehavior;

class CommentFormModel extends Model{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $commentorFirstName;
    public $commentText;
    public $materialId;
    public $parentId;
    public $introducedAvatar;
    public $encryptedData;
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
     public function rules()
     {
         return [
             [['commentorFirstName', 'commentText', 'verifyCode'], 'required'],
             [['commentorFirstName'], 'string', 'max' => 255],
             [['commentText'], 'string', 'max' => 50000],
            //  ['verifyCode', 'captcha'],
             [['materialId', 'parentId', 'introducedAvatar', 'encryptedData', 'verifyCode'], 'safe']
         ];
     }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['commentorFirstName', 'commentText', 'materialId', 'parentId', 'introducedAvatar', 'encryptedData', 'verifyCode'];
        $scenarios[self::SCENARIO_UPDATE] = ['commentorFirstName', 'commentText', 'materialId', 'parentId', 'encryptedData', 'verifyCode'];

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

    public function behaviors()
    {
        return [
            'purify' => [
                'class' => PurifyBehavior::class,
                'attributes' => ['commentText'],
                'config' => function ($config) {
                                $def = $config->getHTMLDefinition(true);
                                $def->addElement('mark', 'Inline', 'Inline', 'Common');
                                $def->addElement('mark', 'Inline', 'Inline', 'Common');
                                $def->addAttribute('a', 'id', 'Text');
                                $def->addAttribute('img', 'class', 'Text');
                                $def->addAttribute('a', 'target', 'Text');
                                $def->addAttribute('a', 'name', 'ID');
                                $config->set('Attr.EnableID', true);
                                $config->set('HTML.SafeIframe', true);
                                $config->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%'); //allow YouTube and Vimeo
                            }
            ]
        ];
    }
}