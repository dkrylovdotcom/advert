<?php

namespace modules\advert\widgets;

use Yii;
use modules\advert\repositories\read\AdvertReadRepository;
use yii\base\Widget;
use yii\caching\TagDependency;

/**
 * Class ZoneWidget
 */
class ZoneWidget extends Widget
{
    public $identity;
    public $cacheTime;

    public $viewPath;
    private $repository;

    public function __construct(AdvertReadRepository $repository, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;

        $this->viewPath = \Yii::$app->params['themesPath'] . \Yii::$app->template->getName() . '/modules/advert/widgets/advert/';
    }

    public function run()
    {
        $zone = Yii::$app->cache->getOrSet(['zone-'.$this->identity], function() {
            return $this->repository->findByZone($this->identity);
        }, $this->cacheTime, new TagDependency(['tags' => ['zone-'.$this->identity]]));


        $viewFile = $this->viewPath . 'zone-' . $this->identity;

        return $this->render($viewFile, [
            'zone' => $zone
        ]);
    }
}
