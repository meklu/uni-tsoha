<?php

class Model {
	function __construct($attr) {
		foreach ($attr as $k => $v) {
			if (property_exists($this, $k)) {
				$this->{$k} = $v;
			}
		}
	}

	function errors() {
		$ret = array();

		foreach ($this->validators as $v) {
			$r = $v();
			if ($r !== true) {
				$ret[] = $r;
			}
		}

		return $ret;
	}

	protected static function _all($orderBy = "id") {
		$db = Database::conn();
		$q = $db->prepare("SELECT * FROM " . static::class . " ORDER BY " . $orderBy);
		$q->execute();

		$rows = $q->fetchAll(PDO::FETCH_ASSOC);
		$ret = array();

		foreach ($rows as $row) {
			$ret[] = new static($row);
		}

		return $ret;
	}

	protected static function _find($id) {
		$db = Database::conn();
		$q = $db->prepare("SELECT * FROM " . static::class . " WHERE id = :id LIMIT 1");
		$q->bindValue(":id", $id, PDO::PARAM_INT);
		$q->execute();

		$row = $q->fetch(PDO::FETCH_ASSOC);
		if (!$row) {
			return null;
		}

		return new static($row);
	}

	/** @param array $fields Oleelliset kentät muotoa seuraava:
	 * array(
	 *    "<kenttä>" => PDO::PARAM_<TYYPPI>,
	 * )
	 */
	protected static function _save($object, $fields) {
		$fkeys = array_keys($fields);
		$fstr = implode(", ", $fkeys);
		$fsub = array();
		foreach ($fkeys as $f) {
			$fsub[] = ':' . $f;
		}
		$fsubstr = implode(", ", $fsub);

		$db = Database::conn();

		$q = $db->prepare("INSERT INTO " . static::class . " ({$fstr}) VALUES ({$fsubstr}) RETURNING id");
		foreach ($fields as $field => $type) {
			$q->bindValue(":{$field}", $object->{$field}, $type);
		}
		$q->execute();

		$row = $q->fetch(PDO::FETCH_ASSOC);
		if (!$row) {
			return null;
		}

		$object->id = $row["id"];
		return $object;
	}

	protected static function _update($object, $fields) {
		if (!is_int($object->id)) {
			return null;
		}
		$fkeys = array_keys($fields);
		foreach ($fkeys as $k => $v) {
			$fkeys[$k] = "{$v} = :{$v}";
		}
		$fstr = implode(", ", $fkeys);

		$db = Database::conn();

		$q = $db->prepare("UPDATE " . static::class . " SET {$fstr} WHERE id = :id RETURNING id");
		foreach ($fields as $field => $type) {
			$q->bindValue(":{$field}", $object->{$field}, $type);
		}
		$q->bindValue(":id", $object->id, PDO::PARAM_INT);
		$q->execute();

		$row = $q->fetch(PDO::FETCH_ASSOC);
		if (!$row) {
			return null;
		}

		return $object;
	}
}
