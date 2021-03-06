<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Carousel;
use yii\helpers\HtmlPurifier;
use common\modules\UploadHelper;
use yii\widgets\ActiveForm;

/**
 * @var array $slider
 * @var $this \yii\web\View
 * @var $page \common\models\Pages
 * @var $contents \common\models\Pages[]
 * @var $newsFeeds \common\models\Pages[]
 * @var $model \frontend\models\ContactForm;
 */

AppAsset::register($this);
$this->title = \Yii::t('app','Welcome');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language ?>">
<head>
    <meta charset="<?= \Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="/css/timeline.css" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>
<?= $this->render('/layouts/_navbar') ?>
<div style="margin-top: -20px;">
    <?= Carousel::widget([
        'items' => $slider,
        'options' => [
            'class' => 'index-slider slide'
        ],
        'controls' => [
            '<span class="glyphicon glyphicon-chevron-left"></span>',
            '<span class="glyphicon glyphicon-chevron-right"></span>',
        ]
    ]);
    ?>
</div>
<section id="services">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading">
                <?=Yii::$app->controller->settings['site_name']?>
            </h2>
            <h3 class="section-subheading text-muted">
                <?=Yii::t('app','Lorem ipsum dolor sit amet consectetur.')?>
            </h3>
            <br>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-danger"></i>
                    <i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">Phase Two Expansion</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
            </div>
            <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-laptop fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">Phase Two Expansion</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
            </div>
            <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-success"></i>
                    <i class="fa fa-lock fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">Phase Two Expansion</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
            </div>
        </div>
    </div>
</section>
<section class="bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="text-center">
                <h2 class="section-heading">
                    <?=Yii::$app->controller->settings['site_name']?>
                </h2>
                <h3 class="section-subheading text-muted">
                    <?=Yii::t('app','Lorem ipsum dolor sit amet consectetur.')?>
                </h3>
                <br>
            </div>
            <?php foreach ($contents as $content):?>
                <div class="col-sm-4">
                    <div class="thumbnail" style="padding: 0; border: 1px solid #eee;">
                        <?= Html::a(
                            UploadHelper::getHtml('content/' . $content->id, 'medium'),
                            ['view', 'id' => $content->id]
                        ) ?>
                        <div class="caption text-center">
                            <h3>
                                <?= Html::encode($content->title) ?>
                                <br>
                                <small><?= Html::a(\Yii::t('app', 'View More'), ['view', 'id' => $content->id]) ?></small>
                            </h3>
                            <?= HtmlPurifier::process(substr($content->description, 0, 200)) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="bg-primary">
    <div class="container text-center">
        <?= HtmlPurifier::process($page->description) ?>
    </div>
</section>
<section>
    <div class="container">
        <div class="text-center form-group">
            <h2 class="section-heading"><?=Yii::t('app','News Feed')?></h2>
            <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
        <hr>

        <ul class="timeline">
            <?php foreach ($newsFeeds as $key => $feed) :?>
                <li class="<?=(($key % 2) == 0) ? 'timeline-inverted' : ''?>">
                    <div class="timeline-image">
                        <?=UploadHelper::getHtml('news/' . $feed->id, 'medium', ['class' => 'img-circle img-responsive'])?>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>
                                <?=$feed->title?>
                                <hr style="margin: 5px 0 0;">
                                <small class="text-muted"><?=Yii::$app->formatter->asDate($feed->created_at)?></small>
                            </h4>
                        </div>
                        <div class="timeline-body">
                            <?= HtmlPurifier::process(substr($feed->description, 0, 200)) ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>

            <li class="timeline-inverted">
                <div class="timeline-image">
                    <h4>Be Part
                        <br>Of Our
                        <br>Story!</h4>
                </div>
            </li>
        </ul>
    </div>
</section>
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
</section>

<?= $this->render('/layouts/_footer') ?>
<?= $this->render('/layouts/_flash', []) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
