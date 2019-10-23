<?php

/* @var $this yii\web\View */
/* @var $model modules\advert\forms\AdvertForm */

$this->title = 'Создание рекламной зоны';
$this->params['breadcrumbs'][] = ['label' => 'Список рекламных зон', 'url' => ['index']];
?>
<div class="advert-zone-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
