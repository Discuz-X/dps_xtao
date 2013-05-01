<?php
class LtDbConnectionAdapterPdo implements LtDbConnectionAdapter {

	public function connect($connConf) {
		// $option = array(PDO::ATTR_PERSISTENT => true);
		if(isset($connConf['pconnect']) && TRUE == $connConf['pconnect']) {
			$option[PDO::ATTR_PERSISTENT] = TRUE;
		} else {
			$option[PDO::ATTR_PERSISTENT] = FALSE;
		}
		switch($connConf['adapter']) {
			case "pdo_mysql":
				$dsn = "mysql:host={$connConf['host']};dbname={$connConf['dbname']}";
				break;
			case "pdo_sqlite":
				$connConf["host"] = rtrim($connConf["host"], '\\/').DIRECTORY_SEPARATOR;
				if(!is_dir($connConf["host"])) {
					if(!@mkdir($connConf["host"], 0777, TRUE)) {
						trigger_error("Can not create {$connConf['host']}");
					}
				}
				$dsn = "{$connConf['sqlite_version']}:{$connConf['host']}{$connConf['dbname']}";
				break;
			case "pdo_pgsql":
				$dsn = "pgsql:host={$connConf['host']} port={$connConf['port']} dbname={$connConf['dbname']} user={$connConf['username']} password={$connConf['password']}";
				break;
			case "odbc":
				$dsn = "odbc:".$connConf["host"];
				break;
		}

		return new PDO($dsn, $connConf['username'], $connConf['password'], $option);
	}

	public function exec($sql, $connResource) {
		return $connResource->exec($sql);
	}

	public function query($sql, $connResource) {
		return $connResource->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 *
	 * @todo pgsql support
	 */
	public function lastInsertId($connResource) {
		return $connResource->lastInsertId();
	}

	public function escape($sql, $connResource) {
		// quote返回值带最前面和最后面的单引号, 这里去掉, DbHandler中加
		return trim($connResource->quote($sql), "'");
	}
}
