<?php /* @var array $params */ ?>
<?php \Lib\View\ViewManager::show('header', ['title' => $params['title']]); ?>
<?php ?>

<?php if ($params['result']['items']):?>
<?php if (isset($params['result']['alert'])):?>
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <?=$params['result']['alert']['text']?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif;?>
<table class="table table-striped mt-3">
	<thead>
	<tr>
		<?php foreach ($params['result']['columns'] as $column): ?>
			<th scope="col"><?=$column?></th>
		<?php endforeach; ?>
		<th scope="col">Действия</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($params['result']['items'] as $item): ?>
	<tr>
		<?php foreach ($item as $el): ?>
			<?php if ($el['type'] == 'text'):?>
                <td><?=$el['value']?></td>
			<?php elseif($el['type'] == 'photo'):?>
                <td><a href="<?=$el['value']?>" target="_blank">Посмотреть фото</a></td>
			<?php elseif($el['type'] == 'link'):?>
                <td><a href="<?=$el['link']?>"><?=$el['value']?></a></td>
			<?php endif;?>
		<?php endforeach;?>
		<td>
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" id="element_actions" data-bs-toggle="dropdown" aria-expanded="false">Выбрать действие</button>
                <ul class="dropdown-menu" aria-labelledby="element_actions">
                    <?php if ($params['currentUrl'] == '/clients/'):?>
                        <li><a href="/loans/?client_id=<?=$item['id']['value']?>" class="dropdown-item">Посмотреть займы</a></li>
                    <?php endif;?>
                    <li><a href="<?=$params['currentUrl']?>edit/?id=<?=$item['ID']['value']?>" class="dropdown-item">Изменить</a></li>
                    <li><a href="<?=$params['currentUrl']?>delete/?id=<?=$item['ID']['value']?>" class="dropdown-item confirm-delete">Удалить</a></li>
                </ul>
            </div>
		</td>
	</tr>
	<?php endforeach;?>
	</tbody>
</table>
<?php else:?>
    <div class="alert alert-warning alert-dismissible fade show mt-5" role="alert">
        Элементов не найдено
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<div class="pt-5">
    <a href="<?=$params['currentUrl']?>add/" class="btn btn-dark">Добавить запись</a>
</div>

<?php \Lib\View\ViewManager::show('footer'); ?>
