<?php /* @var array $params */ ?>
<?php \Lib\View\ViewManager::show('header', ['title' => $params['title']]); ?>

<form class="pt-4" method="post" action="<?=$params['result']['action']?>" enctype="multipart/form-data">
    <?php foreach ($params['result']['items'] as $item): ?>
            <?php if (isset($item['value']) && $item['code'] == 'id'):?>
                <input type="hidden" name="id" value="<?=$item['value']?>">
            <?php elseif ($item['type'] == 'list'):?>
            <label for="input<?=$item['code']?>" class="form-label"><?=$item['name']?></label>
            <select class="form-select form-select-lg mb-3" id="input<?=$item['code']?>" name="<?=$item['code']?>" aria-label="Выберите клиента" required>
                <?php foreach ($item['list_values'] as $list):?>
                    <option <?=(isset($item['value']) && $item['value'] == $list['id']) ? 'selected' : ''?> value="<?=$list['id']?>"><?=$list['name']?></option>
                <?php endforeach;?>
            </select>
			<?php elseif ($item['type'] == 'file'):?>
            <label for="input<?=$item['code']?>" class="form-label"><?=$item['name']?></label>
            <input type="file" id="input<?=$item['code']?>" name="<?=$item['code']?>" class="form-control form-control-sm" aria-label="Выберите файл">
			<?php elseif ($item['type'] == 'date'):?>
            <label for="input<?=$item['code']?>" class="form-label"><?=$item['name']?></label>
            <input type="date" class="form-control <?=isset($item['error']) && mb_strlen($item['error'])? 'is-invalid' : ''?>" placeholder="<?=$item['name']?>" name="<?=$item['code']?>" id="input<?=$item['code']?>" aria-describedby="<?=$item['code']?>Help" value="<?=$item['value'] ?? ''?>" required>
			<?php else:?>
            <div class="mb-3">
                <label for="input<?=$item['code']?>" class="form-label"><?=$item['name']?></label>
                <input type="text" class="form-control <?=isset($item['error']) && mb_strlen($item['error'])? 'is-invalid' : ''?>" placeholder="<?=$item['name']?>" name="<?=$item['code']?>" id="input<?=$item['code']?>" aria-describedby="<?=$item['code']?>Help" value="<?=$item['value'] ?? ''?>" required>
                <?php if (isset($item['error']) && mb_strlen($item['error'])):?>
                    <div id="<?=$item['code']?>Help" class="invalid-feedback"><?=$item['error']?></div>
                <?php endif;?>
            </div>
            <?php endif;?>
    <?php endforeach;?>
    <button type="submit" class="btn btn-dark">Отправить</button>
</form>

<?php \Lib\View\ViewManager::show('footer'); ?>
