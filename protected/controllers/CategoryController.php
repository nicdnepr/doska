<?php

class CategoryController extends Controller
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
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            'ajaxOnly + list',
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
                'actions' => ['REST.GET', 'REST.PUT', 'REST.POST', 'REST.OPTIONS', 'index', 'paidAdverts'],
                'users' => ['*'],
            ],
            [
                'allow',
                'actions' => ['list'],
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
     */
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionList()
    {
        if (isset($_POST['Advert'])) {

            $data = Category::model()->getCategorys($_POST['Advert']['category_id']);

            foreach ($data as $item) {
                echo CHtml::tag('option',
                    array('value' => $item->id), CHtml::encode($item->name), true);
            }
        }

    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Category;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Category']))
        {
            $model->attributes=$_POST['Category'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Category']))
        {
            $model->attributes=$_POST['Category'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
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

    /**
     * Lists all models.
     */
    public function actionIndex($code = null, $q = null)
    {

        Yii::app()->session['code'] = $code;
        $this->layout = 'column1';

        if (isset(Yii::app()->session['geoForm'])) {
            $geoForm = Yii::app()->session['geoForm'];
        } else {
            $geoForm = new GeoForm();
        }

        if (isset($_POST['GeoForm'])) {
            $geoForm->attributes = $_POST['GeoForm'];
            Yii::app()->session['geoForm'] = $geoForm;
        }

        $this->render('index', [
            'treeViewData'=>Category::model()->getTreeviewData(),
            'dataProvider'=>Advert::model()->getList($code, $q),
            'geoForm' => $geoForm
        ]);
    }

    /**
     * display only platinum/silver adverts for selected category
     * @param $url
     * @param $type
     */
    public function actionPaidAdverts($type, $url)
    {
        $category = Category::model()->getCached($url);

        $this->pageTitle = $type . ' ' . $category->name;

        $this->render('paidList', [
            'dataProvider' => Advert::model()->getList($url, null, false, $type),
        ]);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Category('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Category']))
            $model->attributes=$_GET['Category'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Category the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Category::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Category $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
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

        $this->onRest('model.with.relations', function($model) {
            return [];
        });

    }
}
