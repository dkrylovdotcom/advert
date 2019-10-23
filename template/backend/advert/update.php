<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\advert\helpers\AdvertHelper;
use modules\advert\helpers\AdvertZoneHelper;

/* @var $this yii\web\View */
/* @var $advert modules\advert\entities\Advert */
/* @var $model modules\advert\forms\AdvertForm */

$this->params['breadcrumbs'][] = ['label' => 'Список рекламных объявлений', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование рекламного объявления';
?>
<div class="catalog-form">
    <div class="g-m30">
        <div class="b-form2">
            <div class="b-form2__title">
                <div class="g-clearfix grid__row">
                    <?= Html::a('Содержимое', ['items', 'id' => $advert->id], [
                        'class' => 'g-float_l b-btn b-btn_green'
                    ]); ?>
                    <div class="g-float_r">
                        <?php if($advert->isDraft()): ?>
                            <?= Html::a('Активировать', ['activate', 'id' => $advert->id], [
                                'class' => 'b-btn b-btn_green',
                                'data-method' => 'post',
                            ]); ?>
                        <?php elseif($advert->isActive()): ?>
                            <?= Html::a('В черновики', ['draft', 'id' => $advert->id], [
                                'class' => 'b-btn b-btn_grey',
                                'data-method' => 'post',
                            ]); ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>


            <?php $form = ActiveForm::begin([
                'id' => 'form',
                'options'=>[
                    'autocomplete'=>'on',
                    'method' => 'post',
                    'class' => 'g-m25',
                    'enctype' => 'multipart/form-data',
                ],
                'fieldConfig' => [
                    'template' => '<div class="b-form2__row">{label}{input}{error}</div>',
                    'options' => [
                        'tag' => 'div',
                        'class' => '',
                    ],
                    'hintOptions' => [
                        'class' => '',
                        'tag' => 'div',
                    ],
                    'errorOptions' => [
                        'class' => 'help-message',
                        'tag' => 'span',
                    ],
                    'labelOptions' => [
                        'class' => 'b-form2-row__label',
                    ],
                    'inputOptions' => [
                        'class' => 'b-form2-row__input',
                    ],
                ],
            ]); ?>

            <div class="b-tabs">
                <input id="b-tabs__tab1" class="b-tabs__input" type="radio" name="tabs" checked>
                <label for="b-tabs__tab1" title="Вкладка 1">Общее</label>


                <section class="b-tabs__content" id="b-tabs-tab1__content">
                    <div class="g-clearfix grid__row">
                        <div class="grid__col-1-2">
                            <div class="g-m20">
                                <?= $form
                                    ->field($model, 'zoneId')
                                    ->dropDownList(AdvertZoneHelper::zonesList(), [
                                        'class' => 'b-form2-row__select'
                                    ]) ?>

                                <?= $form
                                    ->field($model, 'isRotate')
                                    ->dropDownList(AdvertHelper::rotateVariants(), [
                                        'class' => 'b-form2-row__select'
                                    ]) ?>

                                <?= $form
                                    ->field($model, 'description')
                                    ->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'startDate')->widget(\yii\jui\DatePicker::class, [
                                    'inline' => true,
                                    'language' => 'ru-Ru',
                                    'dateFormat' => 'yy-MM-dd',
                                    'clientOptions' => [
                                        'changeMonth' => 'true',
                                        'changeYear' => 'true',
                                        'firstDay' => '1',
                                    ]
                                ]) ?>

                                <?= $form->field($model, 'endDate')->widget(\yii\jui\DatePicker::class, [
                                    'inline' => true,
                                    'language' => 'ru-Ru',
                                    'dateFormat' => 'yy-MM-dd',
                                    'clientOptions' => [
                                        'changeMonth' => 'true',
                                        'changeYear' => 'true',
                                        'firstDay' => '1',
                                    ]
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="b-form2__row g-text-center">
                <?= Html::submitButton('<i class="fa fa-save"></i> Сохранить', ['class' => 'b-btn b-btn_green']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
