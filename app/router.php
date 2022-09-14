<?php

// Индексовая страница

\Lib\Http\Router::getInstance()->run(
	'/',
	\App\Controller\IndexController::class,
	'exec',
	'get',
	[
		'title' => 'Главная страница'
	]
);

// Клиенты

\Lib\Http\Router::getInstance()->run(
	'/shooting-style/',
	\App\Controller\ShootingStyleController::class,
	'show',
	'get',
	[
		'title' => 'Стили съёмки'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/shooting-style/edit/',
	\App\Controller\ShootingStyleController::class,
	'showEditPage',
	'get',
	[
		'title' => 'Изменение стиля съёмки: !NAME!'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/shooting-style/edit/',
	\App\Controller\ShootingStyleController::class,
	'edit',
	'post',
	[
		'title' => 'Изменение стиля съёмки'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/shooting-style/add/',
	\App\Controller\ShootingStyleController::class,
	'showAddPage',
	'get',
	[
		'title' => 'Добавить стиль съёмки'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/shooting-style/add/',
	\App\Controller\ShootingStyleController::class,
	'add',
	'post',
	[
		'title' => 'Добавить Стиль съёмки'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/shooting-style/delete/',
	\App\Controller\ShootingStyleController::class,
	'delete',
	'get',
	[
		'title' => 'Удалить Стиль съёмки'
	]
);

// Займы

\Lib\Http\Router::getInstance()->run(
	'/photographers/',
	\App\Controller\PhotographersController::class,
	'show',
	'get',
	[
		'title' => 'Фотографы'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/photographers/edit/',
	\App\Controller\PhotographersController::class,
	'showEditPage',
	'get',
	[
		'title' => 'Изменение Фотографа №!ID!'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/photographers/edit/',
	\App\Controller\PhotographersController::class,
	'edit',
	'post',
	[
		'title' => 'Изменение Фотографа'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/photographers/add/',
	\App\Controller\PhotographersController::class,
	'showAddPage',
	'get',
	[
		'title' => 'Добавить Фотографа'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/photographers/add/',
	\App\Controller\PhotographersController::class,
	'add',
	'post',
	[
		'title' => 'Добавить Фотографа'
	]
);

\Lib\Http\Router::getInstance()->run(
	'/photographers/delete/',
	\App\Controller\PhotographersController::class,
	'delete',
	'get',
	[
		'title' => 'Удалить Фотографа'
	]
);