<?php

namespace coderius\comments\widgets\captcha;

use yii\captcha\Captcha;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\captcha\CaptchaAction;
use yii\helpers\Url;

class CaptchaWidget extends Captcha{

    public $clientOptions = [];
    
    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        $options = $this->getClientOptions();
        $options = empty($options) ? '' : Json::htmlEncode($options);
        $id = $this->imageOptions['id'];
        $view = $this->getView();
        CaptchaWidgetAsset::register($view);
        $view->registerJs("jQuery('#$id').coderiusCaptcha($options);");
    }

    /**
     * Returns the options for the captcha JS widget.
     * @return array the options
     */
    public function getClientOptions()
    {
        $route = $this->captchaAction;
        if (is_array($route)) {
            $route[CaptchaAction::REFRESH_GET_VAR] = 1;
        } else {
            $route = [$route, CaptchaAction::REFRESH_GET_VAR => 1];
        }

        $options = [
            'refreshUrl' => Url::toRoute($route),
            'hashKey' => 'coderiusCaptcha/' . trim($route[0], '/'),
        ];

        return ArrayHelper::merge($this->clientOptions, $options);

        
    }

}