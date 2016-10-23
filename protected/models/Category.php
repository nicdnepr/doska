<?php

/**
 * This is the model class for table "Category".
 *
 * The followings are the available columns in table 'Category':
 * @property integer $id
 * @property integer $parent_id
 * @property string $code
 * @property string $name
 * @property string $create_time
 * @property string $update_time
 * @property Category $parent
 * @property Category[] $children
 */
class Category extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, name', 'required'),
            array('code, url', 'unique'),
            array('parent_id', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>100),
            ['url', 'length', 'max'=>255],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, parent_id, code, name, url', 'safe', 'on'=>'search'),
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
            'parent' => [self::BELONGS_TO, 'Category', 'parent_id'],
            'children' => [self::HAS_MANY, 'Category', 'parent_id', 'order' => 'children.code'],
            //'adverts' => [self::MANY_MANY, 'Advert', 'Category_Advert(category_id, advert_id)']
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'parent_id' => 'Parent',
            'code' => 'Code',
            'name' => 'Name',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'url' => 'Url'
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
        $criteria->with = ['parent'];

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.parent_id',$this->parent_id);
        $criteria->compare('t.code',$this->code,true);
        $criteria->compare('t.name',$this->name,true);
        $criteria->compare('t.url',$this->url,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>[
                'pageSize'=>Yii::app()->params->pageSize
            ]
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Category the static model class
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
				'setUpdateOnCreate' => true
			),
		];
	}

    /**
     * return cached category with children, search by code or url
     * @param $code
     * @return mixed|null|static
     * @throws CHttpException
     */
    public function getCached($code)
    {
        if (!$code) return null;

        $category = Yii::app()->cache[__CLASS__ . $code];

        if (!$category) {
            $category = $this->with('children', 'parent')->find('t.code=:code OR t.url=:code', ['code'=>$code]);

            if (!$category) {
                throw new CHttpException(404, 'Not found');
            }
            Yii::app()->cache->set(__CLASS__ . $code, $category, Yii::app()->params->cacheTime);
        }

        return $category;
    }

    public function afterSave()
    {
        parent::afterSave();

        if (!$this->isNewRecord) {
            Yii::app()->cache->delete(__CLASS__ . $this->code);
        }
    }

    public function getCategorys($parent_id = 0)
    {
        if ($parent_id === null) {
            $parent_id = 1;
        }

        $dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM Category');
        $list = $this->cache(Yii::app()->params->cacheTime, $dependency)->findAllByAttributes(['parent_id' => $parent_id]);

        return $list;
    }

    public function getTreeViewData()
    {
        $dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM Category');
        $categorys = $this->cache(Yii::app()->params->cacheTime, $dependency)->with('children')->findAllByAttributes(['parent_id' => 0]);

        $data = [];
        foreach ($categorys as $category) {

            $children = [];

            foreach($category->children as $child) {
                $children[] = [
                    'text' => CHtml::link($child->name, ['category/index', 'code'=>$child->code]),
                ];
            }

            $data[] = [
                'text' => CHtml::link($category->name, ['category/index', 'code'=>$category->code]),
                'children' => $children
            ];

        }

        return $data;
    }
}
