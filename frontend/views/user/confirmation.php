<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/23/15
 * Time: 22:36
 *
 * @var $model \common\models\Confirmation
 * @var $this \yii\web\View
 * @var $paymentMethod array
 * @var $transactionIds array
 */

$this->title = 'Payment Confirmation';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="page-header"><?=$this->title?></h1>
<div class="row">
    <div class="col-lg-6 col-md-8">
        <div class="panel panel-warning">
            <div class="panel-heading">Fill Your Transfer Detail Bellow</div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($model, 'transaction_id')->dropDownList($transactionIds) ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                <?php if ($paymentMethod) echo $form->field($model, 'payment_method')->dropDownList($paymentMethod) ?>
                <?= $form->field($model, 'amount',[
                    'template' => "
                    {label}
                    <div class='input-group'>
                        <span class='input-group-addon'>Rp</span>
                        {input}
                    </div>
                    \n{error}"
                ])->textInput(['maxlength' => 32]) ?>
                <?= $form->field($model, 'note')->textarea(['row' => 3]) ?>
                <?= $form->field($model, 'created_at')->input('date') ?>
                <?= $form->field($model, 'image')->fileInput(['class' => 'btn btn-default form-control', 'accept' => 'image/*']); ?>
                <?= Html::submitButton('Submit', ['class' => 'btn btn-danger']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>

</div>