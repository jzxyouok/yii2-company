<?php

use backend\widget\tinymce\TinyMce;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\category\CategoryWidget;
use common\modules\UploadHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $modelEnglish common\models\PagesLang */
/* @var $modelIndonesia common\models\PagesLang */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="article-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?= $model->isNewRecord ? 'Create' : 'Update' ?>
        </div>
        <div class="panel-body">
            <?= $form->field($model, 'image',[
                'template' => Html::tag('div', UploadHelper::getHtml('content/' . $model->id, 'small')) .
                    "{label}\n{input}\n{hint}\n{error}"
            ])->fileInput(['class' => 'btn btn-default form-control', 'accept' => 'image/*']);?>

            <?= $form->field($model, 'cat_id', ['template' => "{input}\n{hint}\n{error}"])->widget(CategoryWidget::className()) ?>

            <?php
            $tinyMceConfig = \Yii::$app->modules['tiny-mce'];
            $items = [];

            $tinyMceConfig['options']['name'] = 'modelEnglish[description]';
            $items[] = [
                'label' => 'English',
                'content' =>
                    $form->field($modelEnglish, 'title')->textInput(['maxlength' => 255, 'name' => 'modelEnglish[title]']) .
                    $form->field($modelEnglish, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];
            $tinyMceConfig['options']['name'] = 'modelIndonesia[description]';
            $items[] = [
                'label' => 'Indonesia',
                'content' =>
                    $form->field($modelIndonesia, 'title')->textInput(['maxlength' => 255, 'name' => 'modelIndonesia[title]']) .
                    $form->field($modelIndonesia, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];

            echo Tabs::widget([
                'items' => $items
            ]);
            ?>
            <?= $form->field($model, 'order')->input('order') ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
