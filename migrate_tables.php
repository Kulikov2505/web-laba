<?php
$_SERVER["DOCUMENT_ROOT"] = __DIR__;
require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';

// Таблицы для миграции
$tables = [
	'create table shooting_style
(
    ID   int auto_increment
        primary key,
    NAME varchar(255) null
);
',
	'create table photographers
(
    ID                int auto_increment
        primary key,
    NAME              varchar(255) null,
    PHOTO             varchar(255) null,
    BIOGRAPHY         text         null,
    SHOOTING_STYLE_ID int          null,
    BITRH_DATE        date         null,
    constraint photographers_shooting_type_null_fk
        foreign key (SHOOTING_STYLE_ID) references shooting_style (ID)
            on delete cascade
);'
];

// Создаём таблицы
foreach ($tables as $table)
{
	\Lib\DataBase\DB::getInstance()->getConnection()->query($table);
}