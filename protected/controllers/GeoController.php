<?php

class GeoController extends Controller
{
    public function filters()
    {
        return [
            'postOnly'
        ];
    }

    public function actionCountries()
    {
        $data = Geo::getCountries();

        echo CHtml::tag('option', ['value' => ''], 'Select country', true);

        foreach ($data as $id=>$value) {
            echo CHtml::tag('option', ['value' => $id], CHtml::encode($value), true);
        }
    }

    public function actionRegions()
    {
        $data = Geo::getRegions($this->getValueFromPost('country_id'));

        echo CHtml::tag('option', ['value' => ''], 'Select region', true);

        foreach ($data as $id=>$value) {
            echo CHtml::tag('option', ['value' => $id], CHtml::encode($value), true);
        }
    }

    public function actionCities()
    {
        $data = Geo::getCities($this->getValueFromPost('country_id'), $this->getValueFromPost('region_id'));

        echo CHtml::tag('option', ['value' => ''], 'Select city', true);

        foreach ($data as $id=>$value) {
            echo CHtml::tag('option', ['value' => $id], CHtml::encode($value), true);
        }
    }

    private function getValueFromPost($name)
    {
        $items = array_values($_POST);

        return isset($items[0][$name]) ? $items[0][$name] : null;
    }

}
