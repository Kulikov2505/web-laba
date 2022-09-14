<?php /* @var array $params */ ?>
<?php \Lib\View\ViewManager::show(
	'header',
	[
		'title' => $params['title'] ?? ''
    ]
); ?>

<div class="list-group mt-5 ">
    <?php foreach ($params['result'] as $param):?>
        <a href="<?=$param['url']?>" class="list-group-item list-group-item-action"><?=$param['name']?></a>
    <?php endforeach;?>
</div>

<?php \Lib\View\ViewManager::show('footer'); ?>