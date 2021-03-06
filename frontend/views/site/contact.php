<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = \Yii::t('app', 'Contact Us');
$this->params['breadcrumbs'][] = $this->title;
?>
</div>
<section id="contact">
    <div class="container">
        <h2 class="section-heading text-center">Contact Us</h2>
        <?php $form = ActiveForm::begin(['id' => 'contact-form','action' => ['/contact'],]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php if (\Yii::$app->user->isGuest) : ?>
                    <div class="form-group">
                        <?= Html::activeTextInput($model,'name',['placeholder' => Yii::t('app','Name'), 'class' => 'form-control']) ?>
                    </div>
                    <div class="form-group">
                        <?= Html::activeTextInput($model,'email',['placeholder' => Yii::t('app','Email'), 'class' => 'form-control']) ?>
                    </div>
                <?php endif ?>
                <div class="form-group">
                    <?= Html::activeTextInput($model,'subject',['placeholder' => Yii::t('app','Subject'), 'class' => 'form-control']) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('app', 'Submit'), ['class' => 'btn btn-primary btn-lg', 'name' => 'contact-button']) ?>
                </div>
            </div>
            <div class="col-sm-6">
                <?= Html::activeTextarea($model,'body',['placeholder' => Yii::t('app','Body'), 'class' => 'form-control', 'rows' => 11]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="clearfix"></div>
</section>
<div>
