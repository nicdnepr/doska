<?php
/**
 * Created by PhpStorm.
 * User: k
 * Date: 30.08.16
 * Time: 0:48
 */

class Geo
{
    public static function getCountries()
    {

        $key = 'countries';
        $items = Yii::app()->cache[$key];

        if ($items === false) {

            $response = file_get_contents('https://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000&lang=en');

            if (false === $response) {
                return [];
            }

            $json = CJSON::decode($response);
            $items = CHtml::listData($json['response']['items'], 'id', 'title');
            Yii::app()->cache->set($key, $items, Yii::app()->params['geoCacheTime']);

        }

        return $items;
    }

    public static function getCountryName($country_id)
    {
        $items = self::getCountries();
        return isset($items[$country_id]) ? $items[$country_id] : null;
    }

    public static function getRegions($country_id)
    {
        if ($country_id == 0) {
            return [];
        }

        $key = 'regions' . $country_id;
        $items = Yii::app()->cache[$key];

        if ($items === false) {

            $response = file_get_contents("https://api.vk.com/method/database.getRegions?v=5.5&count=1000&lang=en&country_id={$country_id}");

            if (false === $response) {
                return [];
            }

            $json = CJSON::decode($response);
            $items = CHtml::listData($json['response']['items'], 'id', 'title');
            Yii::app()->cache->set($key, $items, Yii::app()->params['geoCacheTime']);
        }

        return $items;
    }

    public static function getRegionName($country_id, $region_id)
    {
        $items = self::getRegions($country_id);
        return isset($items[$region_id]) ? $items[$region_id] : null;
    }

    public static function getCities($country_id, $region_id)
    {
        if ($country_id == 0) {
            return [];
        }

        $key = 'cities' . $country_id . $region_id;
        $items = Yii::app()->cache[$key];

        if ($items === false) {

            $i = 0;
            $items = [];
            $url = "https://api.vk.com/method/database.getCities?v=5.5&need_all=0&count=1000&lang=en&country_id={$country_id}&region_id={$region_id}&offset=";

            while ($i < 10) {

                $response = file_get_contents($url . ($i*1000));

                if (false === $response) {
                    return $items;
                }

                $json = CJSON::decode($response);
                $count = intval($json['response']['count'] / 1000);
                $items = CMap::mergeArray($items, CHtml::listData($json['response']['items'], 'id', 'title'));

                if ($i++ > $count) {
                    break;
                }

            }

            Yii::app()->cache->set($key, $items, Yii::app()->params['geoCacheTime']);
        }

        return $items;
    }

    public static function getCityName($country_id, $region_id, $city_id)
    {
        $items = self::getCities($country_id, $region_id);
        return isset($items[$city_id]) ? $items[$city_id] : null;
    }

}
