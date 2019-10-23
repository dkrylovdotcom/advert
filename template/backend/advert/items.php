<?php

use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\ProductAsset;
use yii\widgets\ActiveForm;
use modules\advert\rbac\Rbac;
ProductAsset::register($this);

/* @var $advert \modules\advert\entities\Advert */

$this->params['breadcrumbs'][] = ['label' => 'Список рекламных объявлений', 'url' => ['index']];

if(Yii::$app->user->can(Rbac::PERM_ADVERT_EDIT)) {
    $this->params['breadcrumbs'][] = ['label' => 'Редактирование объявления', 'url' => ['update', 'id' => $advert->id]];
}
$this->params['breadcrumbs'][] = 'Содержимое объявления';
?>


<div class="advert-image-form">

    <div class="g-m30 b-widget">
        <div class="b-widget__title">
            <div class="g-clearfix grid__row">
                <div class="g-float_l">
                    <?php if(Yii::$app->user->can(Rbac::PERM_ADVERT_EDIT)): ?>
                    <a class="b-btn b-btn_grey" href="<?= Url::to(['update', 'id' => $advert->id]) ?>"><i class="fa fa-arrow-left"></i> Редактировать объявление</a>
                    <?php endif ?>

                    <?php if(Yii::$app->user->can(Rbac::PERM_ADVERT_VIEW)): ?>
                    <a class="b-btn b-btn_grey" href="<?= Url::to(['index']) ?>"><i class="fa fa-list"></i> Список объявлений</a>
                    <?php endif ?>
                </div>
                <div class="g-float_r">
                </div>
            </div>
        </div>

        <div class="content_wrap g-p10">
            <?php if(Yii::$app->user->can(Rbac::PERM_ADVERT_EDIT)): ?>
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                    <?= $form->field($itemsForm, 'files[]')
                        ->fileInput(['multiple' => true, 'accept' => 'image/*'])
                        ->label(false) ?>

                    <button class="g-m-t10 b-btn b-btn_green"><i class="fa fa-upload"></i> Загрузить</button>
                <?php ActiveForm::end() ?>
            <?php endif ?>


            <div class="g-m-t30 g-clearfix grid__row">
                <?php foreach($advert->items as $item): ?>

                    <div class="grid__col-1-6 b-image-wrap" data-row-id="<?= $item->id ?>">
                        <div class="g-m20">
                            <div class="b-image-wrap__image">
                                <?= Html::a(
                                    Html::img($item->getThumbFileUrl('image', 'thumb')),
                                    $item->getUploadedFileUrl('image'),
                                    ['target' => '_blank']
                                ) ?>
                            </div>

                            <div class="g-inline-block b-image-wrap__buttons">
                                <?php if(Yii::$app->user->can(Rbac::PERM_ADVERT_EDIT)): ?>
                                    <div class="g-m10">
                                        <?= Html::beginForm(['toggle-item-status', 'id' => $advert->id, 'itemId' => $item->id], 'post', ['id' => 'status-' . $item->id]) ?>
                                        Активность<input type="checkbox" name="status" onclick="document.getElementById('status-<?= $item->id ?>').submit();" style="height: 20px;width:20px;" <?= ($item->isActive()) ? 'checked' : '' ?>>
                                        <?= Html::endForm() ?>
                                    </div>

                                    <?= Html::a('<i class="fa fa-arrow-left"></i>', ['move-item-up', 'id' => $advert->id, 'item_id' => $item->id], [
                                        'class' => 'b-btn b-btn_grey',
                                        'data-method' => 'post',
                                    ]); ?>
                                    <?= Html::a('<i class="fa fa-trash"></i>', ['delete-item', 'id' => $advert->id, 'item_id' => $item->id], [
                                        'class' => 'b-btn b-btn_red',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Действительно удалить запись?',
                                    ]); ?>
                                    <?= Html::a('<i class="fa fa-arrow-right"></i>', ['move-item-down', 'id' => $advert->id, 'item_id' => $item->id], [
                                        'class' => 'b-btn b-btn_grey',
                                        'data-method' => 'post',
                                    ]); ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
