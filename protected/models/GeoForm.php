<?php
/**
 * Created by PhpStorm.
 * User: k
 * Date: 14.10.16
 * Time: 21:06
 */

class GeoForm extends CFormModel
{
    public $country_id;
    public $region_id;
    public $sub_region_id;

    public function attributeLabels()
    {
        return [
            'country_id' => 'Country',
            'region_id' => 'Region',
            'sub_region_id' => 'Sub region'
        ];
    }

    public function rules()
    {
        return [
            ['country_id, region_id, sub_region_id', 'numerical', 'integerOnly' => true]
        ];
    }
}
