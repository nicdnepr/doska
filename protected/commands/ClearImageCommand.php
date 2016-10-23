<?php

class ClearImageCommand extends CConsoleCommand
{
    public function run()
    {
        $items = TempImage::model()->findAll('DATEDIFF(NOW(),create_time) > 1');

        foreach ($items as $item) {

            $file = dirname(Yii::getPathOfAlias('application')) . '/www' . $item->image;

            if (file_exists($file))
                unlink($file);

            $item->delete();

        }
    }
}