<?php

use yii\helpers\Html;
use common\models\Setting;
use yii\bootstrap\ActiveForm;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'offset' => 'col-sm-offset-3',
                'wrapper' => 'col-sm-9',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);?>
    <div class="panel panel-yellow">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> Update</div>
        <?php foreach ($model as $m) {
            if ($m->readonly == Setting::READONLY_NOT) {
               echo $form->field($m, "[$m->id]value", ['options' => ['class' => 'list-group-item container-fluid']])->textarea()->label(Inflector::camel2words($m->key, true));
            }
        }?>
        <div class="panel-footer">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>