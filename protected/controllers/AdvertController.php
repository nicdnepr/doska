<?php

class AdvertController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
            'postOnly + delete',
            [
                'RestfullYii.filters.ERestFilter + REST.GET, REST.PUT, REST.POST, REST.OPTIONS'
            ],
        );
    }

    public function actions()
    {
        return [
            'REST.'=>'RestfullYii.actions.ERestActionProvider',
        ];
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => ['REST.GET', 'REST.PUT', 'REST.POST', 'REST.OPTIONS', 'display'],
                'users' => ['*'],
            ],
            [
                'allow',
                'actions' => ['create', 'index', 'pay', 'update', 'view'],
                'roles' => [User::ROLE_USER],
            ],
            [
                'allow',
                'roles' => [User::ROLE_ADMIN],
            ],
            [
                'deny',  // deny all users
                'users' => ['*'],
            ],
        ];
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     * @throws CHttpException Access denied
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        if (!Yii::app()->user->checkAccess('updateAdvert', ['advert'=>$model])) {
            throw new CHttpException(403, 'Access denied');
        }

        $this->layout = 'column1';

        $request = Yii::app()->request;
        if ($request->isPostRequest) {

            $token = $request->getPost('stripeToken');

            $gateway = new \Omnipay\Stripe\Gateway();
            $gateway->setApiKey(Yii::app()->params['stripe.secret']);
            $response = $gateway->purchase(['amount' => $model->amount, 'currency' => Advert::CURRENCY, 'token' => $token])->send();

            // Process response
            if ($response->isSuccessful()) {

                // Payment was successful
                //print_r($response);
                Yii::app()->user->setFlash('success', 'Paid success');
                $model->setPaid($token);

            } elseif ($response->isRedirect()) {

                // Redirect to offsite payment gateway
                $response->redirect();

            } else {

                // Payment failed
                throw new CHttpException(500, $response->getMessage());
            }
        }

        $this->render('view',array(
            'model'=>$model,
        ));
    }

    /*
     * display frontend advert
     */
    public function actionDisplay($id)
    {
        $this->layout = 'column1';

        $model = Advert::model()->getCached($id);

        if (Yii::app()->request->requestUri != $model->getSeoUrl()) {
            $this->redirect($model->getSeoUrl(), true, 301);
        }

        $this->render('view',array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Advert;
        $this->layout = 'column1';

        if (Yii::app()->user->checkAccess(User::ROLE_ADMIN)) {
            $model->scenario = 'admin';
        }

        //preview advert
        if (Yii::app()->request->isAjaxRequest) {

            $model->attributes = $_POST['Advert'];
            $model->file = CUploadedFile::getInstance($model, 'file');

            if ($model->validate(['file']) && $model->file instanceof CUploadedFile) {
                $model->saveImage();
                $model->previewFile = $model->image;
            }

            $html = '';
            if ($model->previewFile) {
                $html .= CHtml::image($model->previewFile) . '<br>';
            }

            foreach ($model->attributes as $name=>$attribute) {
                if ($model->filterPreviewAttr($name) && !empty($attribute)) {
                    $html .= '<b>'.$model->getAttributeLabel($name).'</b>' . ' ' . nl2br(CHtml::encode($attribute)) . '<br>';
                }
            }

            echo CJSON::encode([
                'preview'=>$model->previewFile,
                'html'=>$html
            ]);
            Yii::app()->end();

        }

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);

        if(isset($_POST['Advert']))
        {
            $model->attributes=$_POST['Advert'];
            $model->file = CUploadedFile::getInstance($model, 'file');

            if (isset($_POST['Advert']['categoryList'])) {
                $model->categorys = $model->categoryList;
            } else {
                $model->categorys = [];
            }

            if($model->save()) {

                if (!YII_DEBUG) {
                    Mail::prepare('create', $model->id, $model->user_id);
                }

                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException Access denied
     */
    public function actionUpdate($id)
    {
        $this->layout = 'column1';

        $model=$this->loadModel($id);

        $active = $model->active;

        if (!Yii::app()->user->checkAccess('updateAdvert', ['advert'=>$model])) {
            throw new CHttpException(403, 'Access denied');
        }
        if (Yii::app()->user->checkAccess(User::ROLE_ADMIN)) {
            $model->scenario = 'admin';
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Advert']))
        {
            $model->attributes=$_POST['Advert'];
            $model->file = CUploadedFile::getInstance($model, 'file');

            if (isset($_POST['Advert']['categoryList'])) {
                $model->categorys = $model->categoryList;
            } else {
                $model->categorys = [];
            }

            if($model->save()) {

                if (!YII_DEBUG && Yii::app()->user->checkAccess(User::ROLE_ADMIN) && !$active && $model->active) {
                    Mail::prepare('live', $model->id, $model->user_id);
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /*
     * return user list
     * $paid return paid or not paid
     * $active return active or not active
     * $expire
     */
    public function actionIndex($paid = null, $active = null)
    {
        $this->layout = 'column1';

        $this->render('index',array(
            'dataProvider'=>Advert::model()->getOwnList($paid, $active),
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Advert('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Advert']))
            $model->attributes=$_GET['Advert'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Advert the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Advert::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Advert $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='advert-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function restEvents()
    {

        $this->onRest('model.limit', function() {
            return isset($_GET['limit']) ? $_GET['limit'] : Yii::app()->params['limit'];
        });

        $this->onRest('model.filter', function() {

            $filter = [];

            $defaultFilter = [
                [
                    'property' => 'paid',
                    'value' => 1
                ],
                [
                    'property' => 'active',
                    'value' => 1
                ],
                [
                    'property' => 'expiry_date',
                    'value' => date('Y-m-d'),
                    'operator' => '>='
                ]
            ];

            if (isset($_GET['filter'])) {
                $filter = CJSON::decode($_GET['filter']);
            }

            return CJSON::encode(CMap::mergeArray($filter, $defaultFilter));

        });

        $this->onRest('model.sort', function() {

            $sort = [
                [
                    'property' => 'seo2',
                    'direction' => 'DESC'
                ],
                [
                    'property' => 'seo1',
                    'direction' => 'DESC'
                ],
                [
                    'property' => 'name',
                    'direction' => 'ASC'
                ]
            ];

            return isset($_GET['sort'])? $_GET['sort']: CJSON::encode($sort);

        });

        $this->onRest('model.with.relations', function($model) {
            return [];
        });

    }

    public function actionPay($id)
    {
        Yii::app()->omnipay->purchase($id);
    }
}
