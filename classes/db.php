<?php

	class Db {
    	private $dbh = null;

    	public function __construct() {
    		try {
        		$this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
      		} catch(PDOException $e) {
        		echo $e->getMessage();
    		}
    	}
		
		private $users_sql = "SELECT * FROM users";
		private $actions_sql = "SELECT * FROM actions";
		private $history_sql = "SELECT history.id, history.date_time, users.id AS u_user_id, users.username AS username,
		 actions.id AS a_action_id, actions.actionname AS actionname FROM history LEFT JOIN actions ON actions.id = history.action_id
		 LEFT JOIN users ON users.id = history.user_idORDER BY history.id ASC ";
		
		public function getUsers() {
    		$sth = $this->dbh->query($this->users_sql);
      		$sth->setFetchMode(PDO::FETCH_CLASS, 'Users');

      		$objects = array();

      		while($obj = $sth->fetch()) {
        		$objects[] = $obj;
      		}

      		return $objects;
    	}
		
		public function getUsername($username) {
			$sql = $this->users_sql." WHERE username = :username";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':username', $username, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Users');
			$sth->execute();

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return null;
			}
		}
		
		public function getPassword($password) {
			$sql = $this->users_sql." WHERE password = :password";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':password', $password, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Users');
			$sth->execute();

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return null;
			}
		}
		
		public function getUser($id) {
			$sql = $this->users_sql." WHERE id = :id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Users');
			$sth->execute();

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return null;
			}
		}

		public function getHistory() {
			$sql = $this->history_sql;
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Users');
			$sth->execute();

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return null;
			}
		}
		
		public function query($sql, $class_name) {
      		$sth = $this->dbh->query($sql);
      		$sth->setFetchMode(PDO::FETCH_CLASS, $class_name);

      		$objects = array();

      		while($obj = $sth->fetch()) {
        		$objects[] = $obj;
      		}

      		return $objects;
    	}

    	public function get($id, $table_name, $class_name, $sql = null) {
    		if ($sql == null) {
        		$sql = "SELECT * FROM $table_name WHERE id = $id LIMIT 1";
      		}

      		$sth = $this->dbh->query($sql);
      		$sth->setFetchMode(PDO::FETCH_CLASS, $class_name);

      		$objects = array();

      		while($obj = $sth->fetch()) {
        		$objects[] = $obj;
      		}

      		if (count($objects) > 0) {
        		return $objects[0];
      		} else {
        		return null;
      		}
    	}

    	public function __destruct() {
      		$this->dbh = null;
    	}
  	}
?>