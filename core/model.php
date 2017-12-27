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
			$r = $this->{$v}();
			$ret = array_merge($ret, array_values($r));
		}

		return $ret;
	}

	function validate_strlen_min($str, $len) {
		if (strlen($str) < $len) {
			return false;
		}
		return true;
	}

	function validate_strlen_max($str, $len) {
		if (strlen($str) > $len) {
			return false;
		}
		return true;
	}

	protected static function _all($orderBy = "id") {
		$db = Database::conn();
		$q = $db->prepare("SELECT * FROM " . static::class . " ORDER BY " . $orderBy);
		$q->execute();

		$rows = $q->fetchAll(PDO::FETCH_ASSOC);
		$ret = array();

		foreach ($rows as $row) {
			$ret[$row["id"]] = new static($row);
		}

		return $ret;
	}

	protected static function _allByField($field, $value, $type, $orderBy = "id") {
		$db = Database::conn();
		$q = $db->prepare("SELECT * FROM " . static::class . " WHERE {$field} = :{$field} ORDER BY " . $orderBy);
		$q->bindValue(":{$field}", $value, $type);
		$q->execute();

		$rows = $q->fetchAll(PDO::FETCH_ASSOC);
		$ret = array();

		foreach ($rows as $row) {
			$ret[$row["id"]] = new static($row);
		}

		return $ret;
	}

	protected static function _find($id) {
		return static::_findByField("id", $id, PDO::PARAM_INT);
	}

	protected static function _findByField($field, $value, $type) {
		$db = Database::conn();
		$q = $db->prepare("SELECT * FROM " . static::class . " WHERE {$field} = :{$field} LIMIT 1");
		$q->bindValue(":{$field}", $value, $type);
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

	protected static function _delete($id) {
		$db = Database::conn();

		$q = $db->prepare("DELETE FROM " . static::class . " WHERE id = :id RETURNING 1 AS one");
		$q->bindValue(":id", $id, PDO::PARAM_INT);
		$q->execute();

		$row = $q->fetch(PDO::FETCH_ASSOC);
		if (!$row) {
			return false;
		}

		return true;
	}

	protected static function _deleteWhere($id, $field, $value, $type) {
		$db = Database::conn();

		$q = $db->prepare("DELETE FROM " . static::class . " WHERE id = :id AND {$field} = :{$field} RETURNING 1 AS one");
		$q->bindValue(":id", $id, PDO::PARAM_INT);
		$q->bindValue(":{$field}", $value, $type);
		$q->execute();

		$row = $q->fetch(PDO::FETCH_ASSOC);
		if (!$row) {
			return false;
		}

		return true;
	}

	protected static function _clearRelations($id, $reltables) {
		$relfield = strtolower(static::class) . "_id";
		$db = Database::conn();

		foreach ((array) $reltables as $reltable) {
			$q = $db->prepare("UPDATE $reltable SET {$relfield} = null WHERE {$relfield} = :{$relfield}");
			$q->bindValue(":{$relfield}", $id, PDO::PARAM_INT);
			$q->execute();
		}

		return true;
	}

	protected static function _deleteClearingRelations($id, $reltables) {
		$db = Database::conn();
		if (!$db->beginTransaction()) {
			return false;
		}
		$r = true;
		$r = $r && static::_clearRelations($id, $reltables);
		$r = $r && static::_delete($id);
		$r = $r && $db->commit();
		return $r;
	}

	protected static function _deleteClearingRelationsWhere($id, $reltables, $field, $value, $type) {
		$db = Database::conn();
		if (!$db->beginTransaction()) {
			return false;
		}
		$r = true;
		$r = $r && static::_clearRelations($id, $reltables);
		$r = $r && static::_deleteWhere($id, $field, $value, $type);
		$r = $r && $db->commit();
		return $r;
	}

	protected static function _deleteRelations($id, $reltables) {
		$relfield = strtolower(static::class) . "_id";
		$db = Database::conn();

		foreach ((array) $reltables as $reltable) {
			$q = $db->prepare("DELETE FROM $reltable WHERE {$relfield} = :{$relfield}");
			$q->bindValue(":{$relfield}", $id, PDO::PARAM_INT);
			$q->execute();
		}

		return true;
	}
}
