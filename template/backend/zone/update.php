<?php
/* @var $this yii\web\View */
/* @var $advertZone modules\advert\entities\AdvertZone */
/* @var $model modules\advert\forms\AdvertZoneForm */

$this->params['breadcrumbs'][] = ['label' => 'Список рекламных зон', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование рекламной зоны';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
        'advertZone' => $advertZone,
    ]) ?>

</div>
