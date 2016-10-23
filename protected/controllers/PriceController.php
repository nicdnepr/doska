<?php

class PriceController extends Controller
{	
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>['index'],
				'roles'=>[User::ROLE_USER],
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'roles'=>[User::ROLE_ADMIN],
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionUpdate()
	{
		
		$items = Price::model()->findAll();
		
		if (isset($_POST['Price'])) {
			
			$valid = true;
			
			foreach($items as $i=>$item)
			{
				if(isset($_POST['Price'][$i])) {
					
					$item->attributes = $_POST['Price'][$i];
					$valid = $valid && $item->save();
					
				}
			}
			
			if ($valid) {
				Yii::app()->user->setFlash('message', 'Saved');
			}
			
		}
		
		$this->render('update', [
			'items' => $items
		]);
	}
	
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Price');
		
		$this->render('index', [
			'dataProvider'=>$dataProvider
		]);
	}
}