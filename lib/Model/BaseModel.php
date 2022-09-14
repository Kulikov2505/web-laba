<?php

namespace Lib\Model;

use Lib\DataBase\DB;

abstract class BaseModel
{
	/**
	 * Создание записи
	 *
	 * @param $fields
	 */
	public static abstract function create($fields);

	/**
	 * Чтение записи
	 *
	 * @param $filter
	 * @param $params
	 */
	public static abstract function read($filter, $params);

	/**
	 * Обновление записи
	 *
	 * @param $set
	 * @param $filter
	 * @param $fields
	 */
	public static abstract function update($set, $filter, $fields);

	/**
	 * Удаление записи
	 *
	 * @param $filter
	 * @param $fields
	 */
	public static abstract function delete($filter, $fields);

	/**
	 * Делает запрос в БД
	 *
	 * @param string $query
	 * @param array $params
	 * @return bool|\PDOStatement
	 */
	protected static function query(string $query, array $params = []): bool|\PDOStatement
	{
		$stmt = DB::getInstance()->getConnection()->prepare($query);

		foreach ($params as &$param)
		{
			$param = htmlspecialchars(trim($param));
		}

		$stmt->execute($params);

		return $stmt;
	}
}