<?php

/**
 * This is the model class for table "Paylog".
 *
 * The followings are the available columns in table 'Paylog':
 * @property integer $id
 * @property string $transaction_id
 * @property integer $user_id
 * @property integer $advert_id
 * @property string $amount
 * @property string $description
 * @property string $create_time
 * @property string $token
 * @property integer $active
 */
class Paylog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Paylog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, transaction_id, user_id, advert_id, amount, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => [self::BELONGS_TO, 'User', 'user_id']
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_id' => 'Transaction',
			'user_id' => 'User',
			'advert_id' => 'Advert',
			'amount' => 'Amount',
			'create_time' => 'Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('advert_id',$this->advert_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->scopes = 'active';
        $criteria->order = 't.id DESC';
        $criteria->with = 'user';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Paylog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPayments()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('user_id', Yii::app()->user->id);
		$criteria->scopes = 'active';

		$dependency = new CDbCacheDependency('SELECT MAX(create_time) FROM Paylog WHERE user_id=:user_id AND active=1');
		$dependency->params = [':user_id'=>Yii::app()->user->id];

		$dataProvider=new CActiveDataProvider($this->cache(Yii::app()->params->cacheTime, $dependency, 2), [
			'criteria'=>$criteria,
			'sort'=>[
				'defaultOrder'=>'id DESC'
			],
			'pagination'=>[
				'pageSize'=>Yii::app()->params->pageSize,
			]
		]);

		return $dataProvider;
	}

	public function scopes()
	{
		return [
			'active' => [
				'condition'=>'active=1'
			]
		];
	}
}
