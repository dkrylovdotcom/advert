<?php

namespace modules\advert;

use core\modules\control\interfaces\ModuleInterface;
use modules\advert\rbac\Rbac;
use Yii;

/**
 * AdvertModule module definition class
 */
class AdvertModule extends \yii\base\Module implements ModuleInterface
{
    public $cache = 0;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $app = Yii::$app;

        // SetUP Components
        foreach($this->components as $componentName=>$componentValue) {
            $this->$componentName = Yii::createObject($componentValue);
        }


        $this->controllerNamespace = $app->id . '\controllers\modules\\' . $this->id;
        $this->viewPath = \Yii::$app->params['themesPath'] . Yii::$app->template->getName() . '/modules/' . $this->id;
    }


    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param yii\web\Application $app
     */
    public static function bootstrap($app) {}

    public function canView()
    {
        return Yii::$app->user->can(Rbac::PERM_ADVERT_ZONE_VIEW);
    }
}
