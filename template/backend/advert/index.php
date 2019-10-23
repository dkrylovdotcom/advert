<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use modules\advert\helpers\AdvertHelper;
use modules\advert\entities\Advert;
use modules\advert\helpers\AdvertZoneHelper;
use yii\helpers\ArrayHelper;
use modules\advert\rbac\Rbac;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\advert\forms\search\AdvertSearch */
?>
<div class="catalog-index">
    <div class="g-m30">
        <div class="b-table-wrap">
            <div class="b-table-wrap__title">
                <div class="g-clearfix grid__row">
                    <div class="g-float_l">
                        <?php if(Yii::$app->user->can(Rbac::PERM_ADVERT_EDIT)): ?>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'b-btn b-btn_grey']) ?>
                        <?php endif ?>

                        <?php if(Yii::$app->user->can(Rbac::PERM_ADVERT_ZONE_VIEW)): ?>
                        <?= Html::a('Рекламные зоны', ['/advert/zone/index'], ['class' => 'b-btn b-btn_green']) ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'filterRowOptions' => [
                    'class' => 'b-static-table__filters'
                ],
                'layout' => "{items}\n<div class=\"g-text-center\">{summary}</div>",
                'tableOptions' => [
                    'class' => 'b-static-table',

                ],

                'columns' => [
                    [
                        'attribute' => 'zone_id',
                        'filter' => AdvertHelper::rotateVariants(),
                        'value' => function (Advert $model) {
                            $advertZone = ArrayHelper::getValue(AdvertZoneHelper::zonesList(), ['id' => $model->zone_id]);

                            if(Yii::$app->user->can(Rbac::PERM_ADVERT_EDIT)) {
                                return Html::a(Html::encode($advertZone), ['/advert/zone/update', 'id' => $model->zone_id]);
                            }

                            return Html::encode($advertZone);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'is_rotate',
                        'filter' => AdvertHelper::rotateVariants(),
                        'value' => function(Advert $model) {
                            return AdvertHelper::rotateValue($model->is_rotate);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => AdvertHelper::statusList(),
                        'value' => function (Advert $model) {
                            return AdvertHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                    'add_date:datetime',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=>'Действия',
                        'headerOptions' => ['width' => '250'],
                        'template' => '<div class="g-text-center">{link} {update} {delete}</div>',
                        'buttons' => [
                            'link' => function($url, $model) {
                                return Html::a('<i class="fa fa-eye"></i>', ['/advert/advert/items', 'id' => $model->id], ['class' => 'b-btn b-btn_blue']);
                            },
                            'update' => function($url) {
                                return Html::a('<span class="b-btn b-btn_green"><i class="fa fa-pencil"></i></span>', $url);
                            },
                            'delete' => function($url) {
                                return Html::a('<i class="fa fa-trash"></i>', $url, [
                                    'class' => 'b-btn b-btn_red',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Действительно удалить запись?',
                                ]);
                            },
                        ],
                        'visibleButtons' => [
                            'link' => function () {
                                return Yii::$app->user->can(Rbac::PERM_ADVERT_VIEW);
                            },
                            'update' => function () {
                                return Yii::$app->user->can(Rbac::PERM_ADVERT_EDIT);
                            },
                            'delete' => function () {
                                return Yii::$app->user->can(Rbac::PERM_ADVERT_EDIT);
                            },
                        ]
                    ],
                ],
            ]); ?>


            <div class="g-text-center">
                <?php
                echo \yii\widgets\LinkPager::widget([
                    'pagination' => $dataProvider->pagination,

                    // Labels
                    'firstPageLabel' => 'Первая',
                    'lastPageLabel' => 'Последняя',
                    'prevPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                    'nextPageLabel' => '<i class="fa fa-angle-double-right"></i>',
                    'maxButtonCount' => 5,

                    // Customzing options for pager container tag
                    'options' => [
                        'class' => 'b-pagination',
                        'id' => '',
                    ],


                    // Css
                    'pageCssClass' => 'b-pagination__li',
                    'firstPageCssClass' => 'b-pagination__li',
                    'nextPageCssClass' => 'b-pagination__li',
                    'lastPageCssClass' => 'b-pagination__li',
                    'prevPageCssClass' => 'b-pagination__li',
                    'activePageCssClass' => 'b-pagination__li_active',
                    'disabledPageCssClass' => 'b-pagination__li_disable',

                    'linkOptions' => [
                        'class' => 'b-pagination__link',
                    ],
                ]);
                ?>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
