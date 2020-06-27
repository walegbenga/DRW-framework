<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 05/04/20
* Time : 17:40
*/

namespace App\Provider;

class GenerateControllerAPI
{
	public function generateControllerAPI($controllerAPIName){
		$controllerScript = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*//*" . PHP_EOL;
		$controllerScript .= "# Your controller API name" . PHP_EOL . "namespace controllerAPI" . PHP_EOL;
		$controllerScript .= "class " . $controllerAPIName . "ControllerAPI{" . PHP_EOL;
		$controllerScript .= "# Display form". PHP_EOL;
		$controllerScript .= "\tpublic function new() {" . PHP_EOL;
		$controllerScript .= "\t\treturn json_encode(value);" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Process form". PHP_EOL;
		$controllerScript .= "\tpublic function create() {" . PHP_EOL;
		$controllerScript .= "\t\treturn json_decode(file_get_contents('php://input'), TRUE);" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Update/ process an existing form". PHP_EOL;
		$controllerScript .= "\tpublic function update() {" . PHP_EOL;
		$controllerScript .= "\t\treturn json_decode(file_get_contents('php://input'), TRUE);" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# The home page/ default page". PHP_EOL;
		$controllerScript .= "\tpublic function index() {" . PHP_EOL;
		$controllerScript .= "\t\treturn json_encode(value);" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Delete a record". PHP_EOL;
		$controllerScript .= "\tpublic function delete() {" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "}". PHP_EOL;

		# Write to the file'
		$controllerAPI_dir = __DIR__ . '/../app/Controllers/Api';
		$controllerAPIFile = ucfirst($controllerNameAPI) .'ControllerAPI' . '.php';
		if(!file_exists($controllerAPI_dir)){
			mkdir($controllerAPI_dir, 0777, true);
			if(chdir($controllerAPI_dir)){
				file_put_contents($controllerAPIFile, $controllerScript);
			}
			#return true;
		}else{
			if(is_writable($controllerAPI_dir)){
				chdir($controllerAPI_dir);
				file_put_contents($controllerAPIFile, $controllerScript);
				
				#	return true;
			}else{
				return false;
			}
		}
		return true;
	}

}