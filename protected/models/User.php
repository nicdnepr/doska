<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property integer $id
 * @property string $email
 * @property string $hash
 * @property string $password
 * @property string $password2
 * @property string $create_time
 * @property string $role
 * @property integer $discount
 * @property string $f_name
 * @property string $l_name
 * @property string $notes
 * @property string $expiry
 * @property string $phone
 */
class User extends CActiveRecord
{

	const ROLE_ADMIN = 1;
	const ROLE_USER = 2;

    public $password;
    public $password2;
    public $recaptcha;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'User';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        $rules = [
            ['email, f_name, l_name', 'required'],
            ['password, password2', 'required', 'on'=>'insert'],
            ['email', 'unique'],
            ['email, f_name, l_name, phone', 'length', 'max'=>200],
            ['password, password2', 'length', 'min'=>5],
            ['password', 'compare', 'compareAttribute'=>'password2'],
            ['email', 'email'],
            ['expiry, notes', 'safe'],
            ['discount', 'numerical', 'integerOnly'=>true, 'min' => 0, 'max' => 100],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            ['f_name, l_name, email, discount', 'safe', 'on'=>'search'],
        ];

        if (Yii::app()->user->isGuest) {
            $rules = CMap::mergeArray($rules, [
                ['recaptcha', 'required'],
                ['recaptcha', 'ReCaptchaValidator'],
            ]);
        }

        return $rules;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'password2' => 'Confirm password',
            'create_time' => 'Register date',
            'discount' => 'Discount %',
            'f_name' => 'Firstname',
            'l_name' => 'Lastname',
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

        $criteria->compare('f_name',$this->f_name,true);
        $criteria->compare('l_name',$this->l_name,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('discount',$this->discount);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>[
                'pageSize'=>Yii::app()->params->pageSize
            ],
            'sort' => [
                'defaultOrder' => 'create_time DESC'
            ]
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return [
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'updateAttribute' => null
            ),
        ];
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {

            if ($this->isNewRecord) {
                $this->hash = CPasswordHelper::hashPassword($this->password);
                $this->role = self::ROLE_USER;
                $this->expiry = new CDbExpression('DATE_ADD(NOW(), INTERVAL 1 YEAR)');
            } else {
                if (!empty($this->password)) {
                    $this->hash = CPasswordHelper::hashPassword($this->password);
                }
                $this->expiry = date('Y-m-d', strtotime($this->expiry));
            }

            return true;
        } else {
            return false;
        }
    }

    public function afterSave()
    {
        parent::afterSave();

        if (!YII_DEBUG && $this->isNewRecord) {
            Mail::prepare('signups', null, $this->id);
        }

    }

    public function newPassword($email)
    {
        $user = $this->findByAttributes(['email'=>$email]);

        if (!$user) return;

        $password = substr( md5(uniqid('')), 0, 6);

        $user->hash = CPasswordHelper::hashPassword($password);
        $user->save(false);

        $body = Yii::app()->controller->renderPartial(
            '/emails/newPassword',
            [
                'password'=>$password
            ],
            true
        );

        Mail::send($user->email, 'New password', $body);
    }

    public function socialLogin($provider)
    {
        try {

            $hybridauth = new Hybrid_Auth(Yii::getPathOfAlias('application.config') . '/providers.php');
            $adapter = $hybridauth->authenticate($provider);
            $user_profile = $adapter->getUserProfile();

            //fb success login

            $email = !empty($user_profile->email) ? $user_profile->email : 'fb_' . $user_profile->identifier;
            $user = User::model()->findByAttributes(['email' => $email]);

            if (!$user) {
                $user = new User;
                $user->email = $email;
                $user->password = $email;
                $user->save(false);
            }

            $identity = new HybridAuthIdentity($user->email);
            Yii::app()->user->login($identity);

        } catch (Exception $ex) {}
    }

    public function getList()
    {
        $dependency = new CDbCacheDependency('SELECT COUNT(id) FROM User');
        return CHtml::listData($this->cache(Yii::app()->params->cacheTime, $dependency)->findAll(), 'id', 'email');
    }

    public function getName()
    {
        return $this->f_name . ' ' . $this->l_name;
    }
}
