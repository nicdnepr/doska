<?php
/* @var $this AdvertController */
/* @var $model Advert */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile('/js/regions.js');
?>

<div class="row">
    <div class="col-lg-6">

        <div class="form">

        <?php

        $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
            'id'=>'advert-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'htmlOptions' => array(
                'enctype'=>'multipart/form-data',
                'class' => 'well'
            ),
            'clientOptions' => [
                'validateOnSubmit'=>true
            ]
        ));


        if ($model->image) {
            echo '<div class="form-group">';
            echo CHtml::image($model->image);
            echo '</div>';
        }

        echo $form->select2Group($model, 'country_id', [
            'wrapperHtmlOptions' => [

            ],
            'widgetOptions' => [
                'data' => Geo::getCountries(),
                'htmlOptions' => [
                    'empty' => 'Select country',
                    'ajax' => [
                        'type'=>'POST',
                        'url'=>['geo/regions'],
                        'beforeSend'=>'function(data) {
                            display_sub_region();
                            $("select").filter("[name$=\"[region_id]\"], [name$=\"[city_id]\"]").html("").select2();
                        }',
                        'success'=>'function(data) {
                            $("select[name$=\"[region_id]\"]").html(data).select2();
                        }'
                    ],
                ]
            ]
        ]);

        echo $form->select2Group($model, 'region_id', [
            'wrapperHtmlOptions' => [

            ],
            'widgetOptions' => [
                'data' => Geo::getRegions($model->country_id),
                'htmlOptions' => [
                    'ajax' => [
                        'type'=>'POST',
                        'url'=>['geo/cities'],
                        'beforeSend'=>'function(data) {
                            display_sub_region();
                            $("#Advert_city_id").html("").select2().prop("disabled", true);
                        }',
                        'success'=>'function(data) {
                            $("#Advert_city_id").html(data).select2().prop("disabled", false);
                        }'
                    ],
                ]
            ]
        ]);

        ?>

        <div id="sub_region">
            <?= $form->select2Group($model, 'sub_region_id', [
                'wrapperHtmlOptions' => [

                ],
                'widgetOptions' => [
                    'data' => CHtml::listData(SubRegion::model()->findAll(), 'id', 'name'),
                    'htmlOptions' => [
                        'empty' => 'None',
                    ]
                ]
            ]); ?>
        </div>

        <?php

        echo $form->select2Group($model, 'city_id', [
            'wrapperHtmlOptions' => [

            ],
            'widgetOptions' => [
                'data' => Geo::getCities($model->country_id, $model->region_id),
                'htmlOptions' => [
                ]
            ]
        ]);

        echo $form->select2Group($model, 'category_id', [
            'wrapperHtmlOptions' => [

            ],
            'widgetOptions' => [
                'data' => CHtml::listData(Category::model()->getCategorys(), 'id', 'name'),
                'htmlOptions' => [
                    'ajax' => [
                        'type'=>'POST',
                        'url'=>['category/list'],
                        'success'=>'function(data) {
                            $("#Advert_categoryList").html(data).select2();
                        }'
                    ],
                ]
            ]
        ]);

        echo $form->select2Group($model, 'categoryList', [
            'wrapperHtmlOptions' => [

            ],
            'widgetOptions' => [
                'data' => CHtml::listData(Category::model()->getCategorys($model->category_id), 'id', 'name'),
                'htmlOptions' => [
                    'multiple'=>'multiple'
                ]
            ]
        ]);

        echo $form->fileFieldGroup($model, 'file');
        echo $form->textFieldGroup($model, 'name');
        echo $form->textFieldGroup($model, 'address');
        echo $form->textFieldGroup($model, 'postcode');
        echo $form->textFieldGroup($model, 'telephone');
        echo $form->textFieldGroup($model, 'fax');
        echo $form->textFieldGroup($model, 'web');

        echo $form->textFieldGroup($model, 'facebook_url');
        echo $form->textFieldGroup($model, 'twitter_url');
        echo $form->textFieldGroup($model, 'instagram_url');
        echo $form->textFieldGroup($model, 'gplus_url');
        echo $form->textFieldGroup($model, 'youtube_url');
        echo $form->textFieldGroup($model, 'pinterest_url');

        echo $form->emailFieldGroup($model, 'email');
        echo $form->textFieldGroup($model, 'lat');
        echo $form->textFieldGroup($model, 'lng');
        echo $form->textAreaGroup($model, 'description', [
            'widgetOptions' => [
                'htmlOptions' => [
                    'rows'=>6
                ]
            ]
        ]);
        echo $form->textFieldGroup($model, 'manager_name');
        echo $form->textFieldGroup($model, 'mobile');

        echo $form->textFieldGroup($model, 'seo_keywords');
        echo $form->textFieldGroup($model, 'seo_description');

        if ($model->isNewRecord || Yii::app()->user->checkAccess(User::ROLE_ADMIN)) {
            echo $form->dropDownListGroup($model, 'package', [
                'widgetOptions' => array(
                    'data' => Price::model()->getList(),
                    'htmlOptions' => [
                    ],
                )
            ]);
        }

        if (Yii::app()->user->checkAccess(User::ROLE_ADMIN)) {

            echo $form->select2Group($model, 'user_id', [
                'widgetOptions' => array(
                    'data' => User::model()->getList(),
                    'htmlOptions' => [
                    ],
                )
            ]);

            echo $form->datePickerGroup($model, 'expiry_date', [
                'widgetOptions' => array(
                    'options' => [
                        'language' => Yii::app()->language,
                        'format'=>'yyyy-mm-dd',
                        'autoclose' => true
                    ],
                    'htmlOptions' => [
                        'readonly' =>true,
                    ],
                )
            ]);

            echo $form->textFieldGroup($model, 'rating');
            echo $form->checkboxGroup($model, 'active');
            echo $form->checkboxGroup($model, 'paid');
        }

        $this->widget(
            'booster.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'label' => 'Save',
            ]
        );

        echo $form->hiddenField($model,'previewFile');

        $this->endWidget();

        ?>

        </div><!-- form -->
    </div>

    <div class="col-lg-6" id="preview"></div>
</div>

<?php if ($model->isNewRecord): ?>

    <script>

        $(':input').on('change', function(){

            var form = $('#advert-form');
            var formdata = false;
            if (window.FormData){
                formdata = new FormData(form[0]);
            }

            $.ajax({
                url         : [],
                data        : formdata ? formdata : form.serialize(),
                cache       : false,
                contentType : false,
                processData : false,
                type        : 'post',
                dataType    : 'json',
                success     : function(response) {

                    $('#preview').html(response.html);
                    if (response.preview != '') {
                        $('#<?= CHtml::activeId($model, 'previewFile') ?>').val(response.preview);
                    }
                    $(':file').val('');

                }
            });
        });

    </script>

<?php endif; ?>
