<?php
//класс написан пока что только для работы с комментариями и неуниверсален. Это стартовая версия.
class QueryBuilder
{
	protected $pdo;//в классе есть свойство, содержащее объект подключения к БД
	
	public function __construct()
	{
		$this->pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');//это свойство получает объект подключения к БД при создании объекта QueryBuilder.
		//Параменты подключения пока что указаны прямо здесь, далее будут вынесены в конфигурационный файл. Да и сам объект PDO будет передаваться уже созданным вне объектов этого класса
	}

	public function getAllComments()//метод, который используя свойсто класса $this->pdo получает из БД все строки из таблицы comments. 
	//Для универсальности метода имеет смысл получать название таблицы в виде переменной, тогда можно будет получить все строки из любой узазанной таблицы.
	{
		$sql = "SELECT * FROM comments";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getComment($id)//метод получает одну строку из таблицы comments, с заданным параметром id
	//Для универсальности метода можно задавать название таблицы в виде переменной, а также осуществлять поиск не только по id, а по любому заданному полю таблицы
	{
		$sql = "SELECT * FROM comments WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute($id);
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	public function addComment($values)//метод добавляет комментарий и остальные необходимые данные в таблицу comments, получая все необходимые данные в массиве $values
	//Для универсальности метода целесообразно передавать название таблицы в виде переменной, и набор параметров для записи в любую указанную таблицу
	{
		$sql = "INSERT INTO comments (user_id, access, comment) VALUES (:user_id, :access, :comment)";
		$statement = $this->pdo->prepare($sql);
		$statement->execute($values);
	}

	public function updateComment($values)//метод для редактирования записи в таблице comments, получает все необходимые параметры в массиве $values
	//Для универсальности метода можно передавать название таблицы и массив данных, для записи в любую указанную таблицу
	{
		$sql = "UPDATE comments SET user_id = :user_id, access = :access, comment = :comment WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute($values);
	}

	public function deleteComment($id)//метод удаляет строку в БД с заданным id
	//Для универсальности можно передавать название таблицы и любой параметр, по которому надо удалить одну строку или несколько строк из заданной таблицы, содержащие его. 
	{
		$sql = "DELETE FROM comments WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute($id);
	}
}