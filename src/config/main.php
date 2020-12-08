<?php

// var_dump(Yii::getAlias('@coderius/comments/translations'));die;
return [
    'controllerNamespace' => 'coderius\comments\controllers',

    'components' => [
        'request' => [
            'class' => 'yii\web\Request',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        // перевод
        'i18n' => [
            'class' => 'yii\i18n\I18N',
            'translations' => [
                'comments*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' =>  '@coderius/comments/translations',
                    //'sourceLanguage' => 'en-US',
                    'forceTranslation' => true,
                    'fileMap' => [
                        'comments/messages' => 'messages.php',
                    ],
                ],
            ],
        ],
    ],
    'params' => [
        // список параметров
    ],
];
