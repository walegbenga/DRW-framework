<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 05/04/20
* Time : 17:50
*/

namespace Generic\Console\Database;

class GenerateDBModel
{
	private $pdo;
	#include __DIR__ . '/../../../../includes/DatabaseConnection.php';
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function addTableToDB($table, $column = [])
	{
		$cur_dir = getcwd();
		// Check if the table exist and drop it
		$drop = "DROP TABLE IF EXISTS `$table`;";
		$drop_sql = $this->pdo->prepare($drop);
		$drop_sql->execute();
		// Close the $drop query
		$drop_sql->closeCursor();

		$query = 'CREATE TABLE `' . $table . '` (';
		$query .= 'id  int(11) not null primary key auto_increment,';
		foreach($column as $key => $value){
			
			$value = str_ireplace("nn:", "not null", $value);
			$value = str_ireplace("not:", "null", $value);
			$value = str_ireplace("num:", "int", $value);
			$value = str_ireplace("s:", "varchar", $value);
			$value = str_ireplace("string:", "varchar", $value);
			$value = str_ireplace("t:", "time", $value);
			$value = str_ireplace("dt:", "datetime", $value);
			$value = str_ireplace("d:", "date", $value);
			$value = str_replace("dc:", "decimal", $value);
			$value = str_ireplace("fl:", "float", $value);
			$value = str_ireplace("normal:", "default", $value);
			$value = str_ireplace("ref:", "references", $value);
			$value = str_replace("DC:", "ON DELETE CASCADE", $value);
			$value = str_replace("UC:", "ON UPDATE CASCADE", $value);
			$value = str_ireplace("fk:", "foreign key", $value);
			$value = str_replace("U:", "UNIQUE", $value);
			$value = str_replace("DSN:", "ON DELETE SET NULL", $value);
			$value = str_replace("USN:", "ON UPDATE SET NULL", $value);

			$query .= $value . ",";
		}
		$query = rtrim($query, ',');
		$query .= ')';

		/*$query = 'CREATE DATABASE IF NOT EXISTS `' . $db . '`';
		$result = $this->pdo->prepare($query);
		$result->execute();*/
#var_dump($query);
		$sql = $this->pdo->prepare($query);
		$sql->execute();
		$res = 'DESCRIBE `' . $table . '`';
		$resul = $this->pdo->query($res);
		$result = $resul->fetchAll(\PDO::FETCH_CLASS);

		echo 'Generating the model class';
		
		$join = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$join .= "# Your entity name" . PHP_EOL . "namespace App;" . PHP_EOL . PHP_EOL;
		$join .= "class " . ucfirst($table) . "{" . PHP_EOL;
		
		foreach($result as $r){
			$join .= "\tpublic $" .$r->Field . ";" . PHP_EOL;
		}
		$join .= PHP_EOL . "# The construction function". PHP_EOL;
		$join .= "\tpublic function __construct() {". PHP_EOL . "\t}" . PHP_EOL . PHP_EOL;
		$join .= "}" . PHP_EOL;

		# Write to the file'
		$dir = getcwd() . '/app';
		#echo "$dir is a model and is located in \n\n\n\n\n\n\n\n\n";
		$file = ucfirst($table) . '.php';
		
		if(!file_exists($dir)){
			mkdir($dir, 0777, true);
			if(chdir($dir)){
				file_put_contents($file, $join);
			}
			chdir($cur_dir);
			return true;
		}else{
			if(is_writable($dir)){
				chdir($dir);
				file_put_contents($file, $join/*, FILE_APPEND*/);

				chdir($cur_dir);
				return true;
			}else{
			#	return false;
			}
		}
		#$c = chdir(getcwd() . "../");
#var_dump($c);
		return;
	}

	public function generateAdminDB($column = []){
		echo 'Generating the admin model' . "<br/>";
		if(empty($column)){
			$this->addTableToDB('admin', ['first_name s:(100) nn:', 'last_name string:(100) nn:' , 'email s:(100) nn:', 'password s:(100) nn:']);
			$pw = password_hash('secret', PASSWORD_DEFAULT);
			$query = 'INSERT INTO `admin`(`first_name`, `last_name`, `email`, `password`) VALUES ("Willy", "Keysers", "stephenogunbule@drw.com", :pw, "robbert_bassham")';
			$parameters = ['pw' => $pw];
			$sql = $this->pdo->prepare($query);
			$sql->execute($parameters);
		}else{
			$this->addTableToDB('admin', $column);
		}

		echo 'FInished generating the admin model' . '<br/>';
	}

	public function createDb($db, $user = 'secret', $pw = 'secret'){
		$query = 'CREATE DATABASE IF NOT EXISTS `' . $db . '`';
		$result = $this->pdo->prepare($query);
		$result->execute();

		$createUser = "CREATE USER '" . $user . "'@'localhost' IDENTIFIED BY '" . $pw . "'";
		$create = $this->pdo->prepare($createUser);
		$create->execute();

		$grant = "GRANT ALL PRIVILEGES ON `" . $db . "`.* TO `" . $user . "`@'localhost'";
		#GRANT ALL PRIVILEGES ON database_name.* TO 'database_user'@'localhost';
		$update = $this->pdo->prepare($grant);
		$update->execute();

		$use = "USE `" . $db . "`";
		$connect = $this->pdo->prepare($use);
		$connect->execute();
	}

	public function dropDb($db){
		$query = 'DROP DATABASE IF EXISTS`' . $db . '`';
		$result = $this->pdo->prepare($query);
		$result->execute();

		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function dropTable($table){
		$query = 'DROP TABLE IF EXISTS`' . $table . '`';
		$result = $this->pdo->prepare($query);
		$result->execute();

		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function dropUser($user){
		$query = 'DROP USER IF EXISTS`' . $user . '`@localhost';
		$result = $pdo->prepare($query);
		$result->execute();

		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function delModel( $file){
		$file = ucfirst($file . ".php");
		echo "Deleting $file...\n";
		if(is_dir(getcwd() . "/app"))
			if(chdir(getcwd() . "/app"))
				unlink( $file);
			else
				echo "Unable to access the directory\n";
		else
			echo "The directory does not exist\n";
	}
	/*public function delModel($dir, $file){
		$dh = opendir($dir);
		while($data = readdir($dh)){
			if($data == $file){
				unlink($dir . '/' . $file);
				@closedir($data);
			}
		}
	}*/

	public function dropAdmin(){
		$query = "DROP TABLE IF EXISTS`admin`";
		$result = $this->pdo->prepare($query);
		$result->execute();

		if($result){
			return true;
		}else{
			return false;
		}
	}
}