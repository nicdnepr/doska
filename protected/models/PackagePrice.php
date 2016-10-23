<?php

/**
 * This is the model class for table "package_price".
 *
 * The followings are the available columns in table 'package_price':
 * @property integer $id
 * @property integer $country_id
 * @property integer $region_id
 * @property integer $sub_region_id
 * @property string $country_name
 * @property string $region_name
 * @property integer $price_1
 * @property integer $price_2
 * @property integer $price_3
 *
 * The followings are the available model relations:
 * @property SubRegion $subRegion
 */
class PackagePrice extends CActiveRecord
{
    /*
     * type of advert for pay
     */
    const PACKAGE_SILVER = 1;
    const PACKAGE_GOLD = 2;
    const PACKAGE_PLATINUM = 3;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'package_price';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            ['price_1, price_2, price_3, country_id, region_id', 'required'],
            array('country_id, region_id, sub_region_id', 'numerical', 'integerOnly'=>true),
            ['price_1, price_2, price_3', 'numerical'],
            ['country_id', 'uniquePrice', 'message' => 'Price exists for this region'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, country_id, region_id, sub_region_id, price_1, price_2, price_3', 'safe', 'on'=>'search'),
        );
    }

    public function uniquePrice($attribute, $params)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('region_id', $this->region_id);

        if ($this->sub_region_id > 0) {
            $criteria->compare('sub_region_id', $this->sub_region_id);
        } else {
            $criteria->addCondition('sub_region_id IS NULL');
        }

        $criteria->addCondition('id <> :id');
        $criteria->params[':id'] = (int)$this->id;

        if ($this->count($criteria) > 0) {
            $this->addError('country_id', $params['message']);
            $this->addError('region_id', $params['message']);
            $this->addError('sub_region_id', $params['message']);
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'subRegion' => [self::BELONGS_TO, 'SubRegion', 'sub_region_id']
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $attributes = [
            'id' => 'ID',
            'country_id' => 'Country',
            'region_id' => 'Region',
            'sub_region_id' => 'Sub Region',
        ];

        $packageList = Price::model()->findAll();

        foreach ($packageList as $package) {
            $attributes["price_{$package->id}"] = $package->name;
        }

        return $attributes;

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

        $criteria->compare('id',$this->id);
        $criteria->compare('country_id',$this->country_id);
        $criteria->compare('region_id',$this->region_id);
        $criteria->compare('sub_region_id',$this->sub_region_id);
        $criteria->compare('price_1',$this->price_1);
        $criteria->compare('price_2',$this->price_2);
        $criteria->compare('price_3',$this->price_3);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PackagePrice the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->country_name = Geo::getCountryName($this->country_id);
        $this->region_name = Geo::getRegionName($this->country_id, $this->region_id);

        return parent::beforeSave(); // TODO: Change the autogenerated stub
    }
}
