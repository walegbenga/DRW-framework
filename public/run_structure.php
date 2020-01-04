<?php
include __DIR__ . '/../includes/DatabaseConnection.php';
#include __DIR__ . '/../classes/DatabaseConnect.php';
#__DIR__ . '/../classes/Generic/Structure.php';
include __DIR__ . '/../vendor/autoload.php';
$pdo = new PDO('mysql:host=localhost;dbname=k1;charset=utf8', 'gbenga22', 'arsenewenger');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$structure = new \Generic\Structure($pdo);
#$structure->createDb('k1', 'ball', 'papilo');
#generateResetPasswordLayout();
#$structure->scaffold('gov', ['prediction varchar(100) not null', 'games text not null'], true);
#$structure->generateAdminDB();
#['first_name varchar(100) not null', 'last_name varchar(100) not null' , 'email varchar(100) not null', 'password varchar(100) not null', 'username varchar(100) not null']
#['prediction varchar(100) not null', 'games text not null']
#$structure->generateFPModel('coa.com');
#$structure->generateFPModel('cool');
#$structure->generateRPController();
#$structure->generateRoute(['Controllers\GovController', 'Controllers\ForgetPasswordController', 'Controllers\ResetPasswordController'], ['Model\Gov', 'Model\ForgetPassword', 'Model\Access_token']);
function addTableToDB($pdo, $table, $column = []){
		$query = 'CREATE TABLE IF NOT EXISTS `' . $table . '` (';
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
		$sql = $pdo->prepare($query);
		$sql->execute();
		$res = 'DESCRIBE `' . $table . '`';
		$resul = $pdo->query($res);
		$result = $resul->fetchAll(\PDO::FETCH_CLASS);

		echo 'Generating the model class';
		
		$join = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$join .= "# Your entity name" . PHP_EOL . "namespace Model;" . PHP_EOL . PHP_EOL;
		$join .= "class " . ucfirst($table) . "{" . PHP_EOL;
		
		foreach($result as $r){
			$join .= "\tpublic $" .$r->Field . ";" . PHP_EOL;
		}
		$join .= PHP_EOL . "# The construction function". PHP_EOL;
		$join .= "\tpublic function __construct() {". PHP_EOL . "\t}" . PHP_EOL . PHP_EOL;
		$join .= "}" . PHP_EOL;

		# Write to the file'
		$dir = __DIR__ . '/../ModelTest';
		$file = ucfirst($table) . '.php';
		
		if(!file_exists($dir)){
			mkdir($dir, 0777, true);
			if(chdir($dir)){
				file_put_contents($file, $join);
			}
			return true;
		}else{
			if(is_writable($dir)){
				chdir($dir);
				file_put_contents($file, $join/*, FILE_APPEND*/);
				return true;
			}else{
				return false;
			}
		}
	}

	addTableToDB($pdo, 'rosicky', ['prediction string:(100) nn:', 'games text nn:','admin_id num:(11) nn: normal: 100', 'fk:(admin_id) ref: admin(id) DC: UC:']);

	function generateAdminDB($pdo, $column = []){
		echo 'Generating the admin model' . "<br/>";
		if(empty($colum)){
			addTableToDB($pdo, 'admin', ['first_name s:(100) nn:', 'last_name string:(100) nn:' , 'email s:(100) nn:', 'password s:(100) nn:', 'username s:(100) nn:']);
			$pw = password_hash('secret', PASSWORD_DEFAULT);
			$query = 'INSERT INTO `admin`(`first_name`, `last_name`, `email`, `password`, `username`) VALUES ("Willy", "Keysers", "stephenogunbule@example.com", :pw, "robbert_bassham")';
			$parameters = ['pw' => $pw];
			$sql = $pdo->prepare($query);
			$sql->execute($parameters);
		}else{
			addTableToDB('admin', $column);
		}

		echo 'FInished generating the admin model' . '<br/>';
	}
	#generateAdminDB($pdo);
?>