<?php

namespace modules\advert\controllers\backend;

use modules\advert\entities\Advert;
use modules\advert\forms\AdvertForm;
use modules\advert\forms\AdvertItemForm;
use modules\advert\forms\search\AdvertSearch;
use modules\advert\repositories\AdvertRepository;
use modules\advert\services\AdvertService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use modules\advert\rbac\Rbac;

class AdvertController extends Controller
{
    private $service;
    private $adverts;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'items'],
                        'roles' => [Rbac::PERM_ADVERT_VIEW]
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create', 'update', 'activate',
                            'draft', 'delete',
                            'toggle-item-status', 'delete-item', 'move-item-down', 'move-item-up'],
                        'roles' => [Rbac::PERM_ADVERT_EDIT]
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function __construct($id, $module, AdvertService $service, AdvertRepository $adverts, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->adverts = $adverts;
    }


    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->view->title = 'Рекламные зоны';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'advertZone' => $this->findModel($id),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new AdvertForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $advert = $this->service->create($form);
                return $this->redirect(['update', 'id' => $advert->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        $this->view->title = 'Создание рекламного объявления';
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $advert = $this->findModel($id);

        $form = new AdvertForm($advert);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($advert->id, $form);
                return $this->refresh();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        $this->view->title = 'Редактирование рекламного объявления';
        return $this->render('update', [
            'model' => $form,
            'advert' => $advert
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionItems($id)
    {
        $advert = $this->findModel($id);

        $itemsForm = new AdvertItemForm();

        if ($itemsForm->load(Yii::$app->request->post()) && $itemsForm->validate()) {
            try {
                $this->service->addItems($advert->id, $itemsForm);
                return $this->redirect(['items', 'id' => $advert->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        $this->view->title = 'Содержимое объявления';
        return $this->render('items', [
            'advert' => $advert,
            'itemsForm' => $itemsForm,
        ]);
    }

    /**
     * @param integer $id
     * @param $itemId
     * @return mixed
     */
    public function actionToggleItemStatus($id, $itemId)
    {
        try {
            $this->service->toggleItemStatus($id, $itemId);
            Yii::$app->session->setFlash('success', 'Изменения сохранены!');
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['items', 'id' => $id]);
    }


    /**
     * @param integer $id
     * @param $item_id
     * @return mixed
     */
    public function actionDeleteItem($id, $item_id)
    {
        try {
            $this->service->removeItem($id, $item_id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['items', 'id' => $id]);
    }

    /**
     * @param integer $id
     * @param $item_id
     * @return mixed
     */
    public function actionMoveItemUp($id, $item_id)
    {
        $this->service->moveItemUp($id, $item_id);
        return $this->redirect(['items', 'id' => $id]);
    }

    /**
     * @param integer $id
     * @param $item_id
     * @return mixed
     */
    public function actionMoveItemDown($id, $item_id)
    {
        $this->service->moveItemDown($id, $item_id);
        return $this->redirect(['items', 'id' => $id]);
    }


    /**
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
            Yii::$app->session->setFlash('success', 'Запись активирована');
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['update', 'id' => $id]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDraft($id)
    {
        try {
            $this->service->draft($id);
            Yii::$app->session->setFlash('success', 'Запись перемещена в черновики');
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['update', 'id' => $id]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


    /**
     * @param integer $id
     * @return Advert the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advert::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
