<?php
//проведен рефакторинг для более универсальной работы с БД
class QueryBuilder
{
	protected $pdo;
	
	public function __construct($pdo)//объект PDO передается классу извне и приспаивается свойству класса $this->pdo
	{
		$this->pdo = $pdo;
	}

	public function getAll($table)//метод получает название таблицы и возвращает массив данных из этой таблицы
	{
		$sql = "SELECT * FROM {$table}";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getRow($table, $id)//метод возвращает строку из указаной таблицы по заданному id строки
	{
		$sql = "SELECT * FROM {$table} WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$values = ['id' => $id];
		$statement->execute($values);
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	public function addRow($table, $values)//метод добавляет в указанную таблицу строку данных. Получает название таблицы и массив поля/значения
	{
		foreach ($values as $key => $value) {
			$names .= $key . ', ';
			$tags .= ':' . $key . ', ';
		}
		$names = substr($names, 0, -2);
		$tags = substr($tags, 0, -2);
		$sql = "INSERT INTO {$table} ({$names}) VALUES ({$tags})";
		$statement = $this->pdo->prepare($sql);
		$statement->execute($values);
	}

	public function updateRow($table, $values, $id)//метод редактирует данные в указанной таблице с указанным id в соответствии с массивом поля/значения
	{
		foreach ($values as $key => $value) {
			$names .= $key . ' = :' . $key . ', ';
		}
		$names = substr($names, 0, -2);
		$sql = "UPDATE {$table} SET {$names} WHERE id = :id";
		$values['id'] = $id;
		$statement = $this->pdo->prepare($sql);
		$statement->execute($values);
	}

	public function deleteRow($table, $id)//метод удаляет строку в заданной таблице с указанным id
	{
		$sql = "DELETE FROM {$table} WHERE id = :id";
		$values['id'] = $id;
		$statement = $this->pdo->prepare($sql);
		$statement->execute($values);
	}
}