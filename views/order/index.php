<?php
/** @var yii\web\View $this */
/** @var array $dateList */
/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\OrderSearch $searchModel */

use yii\grid\GridView;
use yii\widgets\PjaxAsset;
use yii\helpers\Html;
use yii\helpers\Url;

PjaxAsset::register($this);
$this->title = 'Заказы';
?>
<h1>Заказы</h1>
<div class="row">
    <div class="col-3">
        <?php foreach ($dateList as $year => $item): ?>
            <ul>
                <li>
                    <a class="date-link" data-year = "<?= $year ?>" data-month = "" href="#"><?= $year . ' (' . $item['quantity'] . ')' ?></a>
                    <ul>
                        <?php foreach ($item['months'] as $month): ?>
                            <li>
                                <a class = "date-link" data-year = "<?= $year ?>" data-month = "<?= $month['month'] ?>" href = "#">
                                    <?= Yii::$app->formatter->asDate("2000-" . $month['month'] ."-01", 'LLLL') . ' (' . $month['quantity'] . ')' ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        <?php endforeach; ?>

        <?= Html::beginForm(Url::current(), 'GET', ['id' => 'filter-form', 'data-pjax' => true]); ?>

        <?= Html::activeHiddenInput($searchModel, 'year'); ?>
        <?= Html::activeHiddenInput($searchModel, 'month'); ?>

        <?= Html::endForm() ?>
        <div>
            <a href="<?= Url::toRoute(['order/index']); ?>">Сбросить</a>
        </div>
    </div>

    <div class="col-9">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'sum',
                'created_at'
            ],
        ]) ?>
    </div>
</div>
<?php

$js = <<<JS
    const filterForm = $('#filter-form');
    
    $('.date-link').click(function () {
        $('#ordersearch-year').val($(this).data('year'));
        $('#ordersearch-month').val($(this).data('month'));
        filterForm.submit();
    });    
    
    filterForm.on('submit', function(e) {
        $.pjax({
        timeout: 4000,
        url: filterForm.attr('action'),
        container: '#w0',
        fragment: '#w0',
        data: filterForm.serialize()
    });
});


JS;

$this->registerJs($js);

