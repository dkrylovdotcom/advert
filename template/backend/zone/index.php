<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use modules\advert\helpers\AdvertZoneHelper;
use modules\advert\entities\AdvertZone;
use modules\advert\rbac\Rbac;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\advert\forms\search\ZoneSearch */
?>
<div class="catalog-index">
    <div class="g-m30">
        <div class="b-table-wrap">
            <div class="b-table-wrap__title">
                <div class="g-clearfix grid__row">
                    <div class="g-float_l">
                        <?php if(Yii::$app->user->can(Rbac::PERM_ADVERT_ZONE_EDIT)): ?>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'b-btn b-btn_grey']) ?>
                        <?php endif ?>

                        <?php if(Yii::$app->user->can(Rbac::PERM_ADVERT_VIEW)): ?>
                        <?= Html::a('Рекламные объявления', ['/advert/advert/index'], ['class' => 'b-btn b-btn_green']) ?>
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
                    'identity',
                    'name',
                    [
                        'attribute' => 'status',
                        'filter' => AdvertZoneHelper::statusList(),
                        'value' => function (AdvertZone $model) {
                            return AdvertZoneHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                    'add_date:datetime',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=>'Действия',
                        'headerOptions' => ['width' => '250'],
                        'template' => '<div class="g-text-center">{update} {delete}</div>',
                        'buttons' => [
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
                            'update' => function () {
                                return Yii::$app->user->can(Rbac::PERM_ADVERT_ZONE_EDIT);
                            },
                            'delete' => function () {
                                return Yii::$app->user->can(Rbac::PERM_ADVERT_ZONE_EDIT);
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
