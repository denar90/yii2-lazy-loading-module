<?php
use yii\helpers\Html;
use yii\helpers\Url;
use denar90\LazyLoad\AppAsset;

AppAsset::register($this);

$this->title = 'List of items';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="col-md-12">
    <div class="list-group col-md-12 js-lazy-content">
    </div>

    <button class="btn js-get-more-items hide">More items...</button>

    <div class="js-ui-loader js-loader js-ui-caption"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></div>
</div>

<script id="js-lazy-load-template" type="text/x-handlebars-template">
    {{#items}}
        <div class="list-group-item col-md-6 media js-ui-item-container js-item-container" data-item-id="{{id}}">
            <div class="media-body">
                <h4 class="media-heading">{{title}}</h4>
                <p class="author">{{description}}</p>
                <!-- Write your own helper for edit link -->
                <a href="#" class="btn btn-xs btn-info">
                    <i class="glyphicon glyphicon-edit"></i>
                </a>
            </div>
        </div>
    {{/items}}
</script>

<?php

$this->registerJs("
		$(document).ready(function() {
            var lazyLoadingInstance = new lazyLoading(),
                getDataUrl = '".  Url::toRoute('/lazyload/lazyload/index') ."';
			lazyLoadingInstance.init(getDataUrl);
		});
	");
?>