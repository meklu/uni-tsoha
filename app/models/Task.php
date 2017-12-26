<?php

class Task extends Model {
	public $id;
	public $account_id;
	public $priority_id;
	public $task;

	public $categories;

	function __construct($attr) {
		parent::__construct($attr);
		$this->validators = array(
			"validate_task",
		);
	}

	function validate_task() {
		$err = array();
		$min = 3;
		if (!$this->validate_strlen_min($this->task, $min)) {
			$err[] = "Askareen tulee olla vähintään {$min} merkin pituinen!";
		}
		$max = 255;
		if (!$this->validate_strlen_max($this->task, $max)) {
			$err[] = "Askare saa olla enintään {$max} merkin pituinen!";
		}
		return $err;
	}

	static function all() {
		return static::_all();
	}

	static function allForAccount($acc_id) {
		return static::_allByField("account_id", $acc_id, PDO::PARAM_INT);
	}

	static function find($id) {
		return static::_find($id);
	}

	private static function updateCategories($task) {
		$db = Database::conn();
		$catstr = array();
		$ci = 0;
		foreach ($task->categories as $c) {
			$catstr[] = ":cat_{$ci}_id";
			$ci += 1;
		}
		$catstr = implode(", ", $catstr);
		/* Poista vanhat relaatiot */
		$q = $db->prepare("DELETE FROM TaskCategory WHERE task_id IN (SELECT id FROM Task WHERE account_id = :account_id AND id = :task_id LIMIT 1) AND category_id NOT IN (SELECT id FROM Category WHERE account_id = :account_id AND id IN ({$catstr}))");
		$q->bindValue(":task_id", $task->id, PDO::PARAM_INT);
		$q->bindValue(":account_id", $task->account_id, PDO::PARAM_INT);
		$ci = 0;
		foreach ($task->categories as $c) {
			$q->bindValue(":cat_{$ci}_id", $c, PDO::PARAM_INT);
			$ci += 1;
		}
		$q->execute();
		/* Uudet relaatiot sisään */
		foreach ($task->categories as $c) {
			$q = $db->prepare("INSERT INTO TaskCategory (task_id, category_id) SELECT :task_id, :category_id WHERE NOT EXISTS (SELECT * FROM TaskCategory WHERE task_id = :task_id AND category_id = :category_id) AND EXISTS (SELECT id FROM Task WHERE id = :task_id AND account_id = :account_id LIMIT 1) AND EXISTS (SELECT id FROM Category WHERE id = :category_id AND account_id = :account_id LIMIT 1)");
			$q->bindValue(":task_id", $task->id, PDO::PARAM_INT);
			$q->bindValue(":account_id", $task->account_id, PDO::PARAM_INT);
			$q->bindValue(":category_id", $c, PDO::PARAM_INT);
			$q->execute();
		}
		/* TODO: Palauta oikea tilanne.
		 * Tästä ei sinänsä ole paljoa haittaa, koska tämän jälkeen testataan commitin tila */
		return true;
	}

	static function retrieveCategories($task, $full = true) {
		$db = Database::conn();
		$qstr = "SELECT category_id FROM TaskCategory WHERE task_id = :task_id";
		if ($full) {
			$qstr = "SELECT * FROM TaskCategory INNER JOIN Category ON Category.id = TaskCategory.category_id WHERE task_id = :task_id";
		}
		$q = $db->prepare($qstr);
		$q->bindValue(":task_id", $task->id, PDO::PARAM_INT);
		$q->execute();

		$rows = $q->fetchAll(PDO::FETCH_ASSOC);

		$cat = array();
		$fullcat = array();
		foreach ($rows as $row) {
			$cat[] = $row["category_id"];
			if ($full) {
				$fullcat[$row["category_id"]] = new Category($row);
			}
		}

		$task->categories = $cat;
		if ($full) {
			$task->categoriesObj = $fullcat;
		}

		return true;
	}

	static function save($object) {
		$db = Database::conn();
		if (!$db->beginTransaction()) {
			return false;
		}
		$r = true;
		if ($object->priority_id < 0) {
			$object->priority_id = null;
		}
		$task = static::_save($object, array(
			"account_id" => PDO::PARAM_INT,
			"priority_id" => PDO::PARAM_INT,
			"task" => PDO::PARAM_STR,
		));
		$r = $r && $task;
		/* Luokitukset */
		$r = $r && static::updateCategories($task);
		$r = $r && $db->commit();
		if (!$r) {
			$task->id = null;
			$task = null;
		}
		return $task;
	}

	static function update($object) {
		$db = Database::conn();
		if (!$db->beginTransaction()) {
			return false;
		}
		$r = true;
		if ($object->priority_id < 0) {
			$object->priority_id = null;
		}
		$task = static::_update($object, array(
			"account_id" => PDO::PARAM_INT,
			"priority_id" => PDO::PARAM_INT,
			"task" => PDO::PARAM_STR,
		));
		$r = $r && $task;
		/* Luokitukset */
		$r = $r && static::updateCategories($task);
		$r = $r && $db->commit();
		if (!$r) {
			$task->id = null;
			$task = null;
		}
		return $task;
	}
}
