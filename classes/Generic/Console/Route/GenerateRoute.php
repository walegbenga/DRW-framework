<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 05/04/20
* Time : 17:53
*/

namespace Generic\Console\Route;

class GenerateRoute
{
	public function generateRoute($classControllers = [], $classModels = []){
		$routeScript = "<?php" . PHP_EOL . "declare(strict_types=1);" . PHP_EOL . PHP_EOL;
		$routeScript .= "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$routeScript .= PHP_EOL . "namespace Route;" . PHP_EOL . "# Get all controllers" . PHP_EOL;

		$routeScript .= "use \\Generic\\{" . PHP_EOL;
		$routeScript .= "\tDatabaseTable," . PHP_EOL . "\tRoute," . PHP_EOL . "\tAuthentication" . PHP_EOL . '};';
		$routeScript .= PHP_EOL . PHP_EOL;
		$routeScript .= "use \\Controllers\\{" . PHP_EOL;

		$prebuiltcontroller = ['Controllers\registerController', 'Controllers\loginController'];
		#array_push($classControllers,'ile');
		foreach($prebuiltcontroller as $pc){
			echo $pc . "<br/>";
			array_push($classControllers, $pc);
		}
		#var_dump($classControllers);
		#$classControllers = ['controller\UsersController', 'controller\Product', 'controller\HadminController', 'controller\AdsController'];
		var_dump($classControllers);
		$control = '';
		foreach($classControllers as $classController){
			echo $classController . "<br/>";
			$controllers = new \ReflectionClass($classController);
			$controller = $controllers->getName();
			$control = substr($controller, 12);
			$control = ucfirst($control);
			$routeScript .= "\t$control" . "," . PHP_EOL;  
		}
		$routeScript = rtrim($routeScript, ',');
		$routeScript .= "};" . PHP_EOL . PHP_EOL;

		# Keep a record of the controller
		# Write to the file'
		$controllerDir = __DIR__ . '/../keep/controllers';
		$controllerFile = "ControllerUpdate.php";
		
		if(!file_exists($controllerDir)){
			mkdir($controllerDir, 0777, true);
			if(chdir($controllerDir)){
				file_put_contents($controllerFile, $routeScript);
			}
			#return true;
			"Good" . "<br/>";
		}else{
			if(is_writable($controllerDir)){
				chdir($controllerDir);
				file_put_contents($controllerFile, $routeScript);
				#return true;
				"love" . "<br/>";
			}else{
				echo "No" . "<br/>";
			}
		}
		
		$routeScript .= "class Routes implements Route{" . PHP_EOL . PHP_EOL;

		$prebuiltModels = ['Model\Admin'];
		foreach($prebuiltModels as $pm){
			echo $pm . "<br/>";
			array_push($classModels, $pm);
		}
		var_dump($classModels);
		#$classModels = ['model\Users', 'model\Product', 'model\Hadmin', 'model\Ads'];

		$mo = '';

		foreach($classModels as $classModel){
			$models = new \ReflectionClass($classModel);

			$model = $models->getName();
			$np = $models->getNamespaceName(); //np means namespace
			$mo = substr($model, 6);
			$mo = lcfirst($mo);

			$routeScript .= "\t" . 'private $' . $mo . 'sTable;' . PHP_EOL . PHP_EOL;
		}

		$routeScript .= "\t# The constructor function". PHP_EOL;
		$routeScript .=  "\tpublic function __construct() {" . PHP_EOL . PHP_EOL;
		$routeScript .= "\t\tinclude __DIR__ . " . "'/includes/DatabaseConnection.php';" . PHP_EOL . PHP_EOL;

		#		$prebuiltModels = ['model\Admin'];
		foreach($prebuiltModels as $pm){
			echo $pm . "<br/>";
			array_push($classModels, $pm);
		}
		var_dump($classModels);
		#$classModels = ['model\Users', 'model\Product', 'model\Hadmin', 'model\Ads'];

		$m = '';
		$p = '';
		
		foreach($classModels as $classModel){
			$models = new \ReflectionClass($classModel);

			$model = $models->getName();
			$np = $models->getNamespaceName(); //np means namespace
			$m = substr($model, 6);
			$m = lcfirst($m);

			$classMethods = new \ReflectionMethod($classModel, "__construct");
			$classParams = $classMethods->getParameters();

			$routeScript .= "\t\t" . '$this->' . $m . 'sTable = new DatabaseTable($pdo, ' . "'$m','id', '\\" . ucfirst($models->getName()) . "'" . ', ['; // Looping through the constructor

			/*if(empty($classMethods)){
			$routeScript .= ")];";
			}*/
			
			foreach($classParams as $classParam){
				$p = $classParam->getName();
				$routeScript .= '&$this->' . $p . ',';
			}
			$routeScript = rtrim($routeScript, ',');
			$routeScript .= ']);' . PHP_EOL;
			if(empty($classMethods)){
				$routeScript .= ");";
			}
		}
		$routeScript .= "\t\t" . '$this->authentication = new Authentication($this->adminsTable, \'email\', \'password\');';
		$routeScript .= PHP_EOL . "\t}" . PHP_EOL . PHP_EOL;
		$routeScript .= "\t" . 'public function getRoutes(): array{' . PHP_EOL;
		
		$c = ''; // c for controller (Creation of new controller)
		$co = ''; // co means controller object (for instantiating a controller)
		$pa = ''; //pa means classParam

		foreach($classControllers as $classController){
			$controllers = new \ReflectionClass($classController);
			$controller = $controllers->getName();
			$c = substr($controller, 12);
			$c = ucfirst($c);
			$co = lcfirst($c);
			echo $co . "<br>";
			$routeScript .= "\t\t" . '$' . "$co = new $c(";

			$classMethods = new \ReflectionMethod($classController, "__construct");
			$classParams = $classMethods->getParameters();

			foreach($classParams as $classParam){
				$pa = $classParam->getName();
				$routeScript .= '$this->' . $pa . ',';
				
			}
			$routeScript = rtrim($routeScript, ',');
			$routeScript .= ');' .PHP_EOL . PHP_EOL;
		}

		$routeScript .= "\t\t" .'$routes = [' .PHP_EOL;
		$cr =''; //cr means controller routes
		$crgp = ''; // Meaning controller routes getRoutes postRoutes
		$getRoutes = ['index', 'show', 'new', 'delete'];
		$postRoutes = ['create'];

		foreach($classControllers as $classController){
			$controllers = new \ReflectionClass($classController);

			$cr = $controllers->getName();
			$crgp = str_ireplace('Controllers\\', '', $cr);
			$crgp = lcfirst($crgp);
			#$cr = lcfirst($cr);
			$cr = str_ireplace('Controllers\\', '', $cr);
			$cr = str_ireplace('Controller', '', $cr);
			$cr = lcword($cr);

			$meth = '';
			foreach($controllers->getMethods() as $method){
				if($method != "__construct"){
					$meth = $method->getName();
					var_dump($method->getName());
					
					if(in_array($meth, $getRoutes)){
						$routeScript .= "\t\t\t '$cr/$meth' => [" . PHP_EOL;
						$routeScript .= "\t\t\t\t" . "'GET' => [" . PHP_EOL . "\t\t\t\t\t'controller' => $" . $crgp . "," . PHP_EOL;
						$routeScript .= "\t\t\t\t\t" . "'action' => '$meth'" . PHP_EOL . "\t\t\t\t ]" . PHP_EOL;
						if($meth === 'new'){
							if(in_array('create', $postRoutes)){
								$routeScript .= "\t\t\t\t ," . PHP_EOL . "\t\t\t\t" . "'POST' => [" . PHP_EOL . "\t\t\t\t\t'controller' => $$crgp," . PHP_EOL . "\t\t\t\t\t'action' => 'create'";
								$routeScript .= PHP_EOL . "\t\t\t\t]" . PHP_EOL /*. "\t\t\t\t]," . PHP_EOL*/;
							}
						}
						$routeScript .= "\t\t\t]," . PHP_EOL;
						/*if($meth === 'delete'){
							#if(in_array($meth, $postRoutes)){
							$routeScript .= "\t\t\t '$cr/$meth' => [" . PHP_EOL;
							$routeScript .= "\t\t\t\t" . "'POST' => [" . PHP_EOL;
							$routeScript .= "\t\t\t\t\t'controller' => $$crgp" . PHP_EOL;
							$routeScript .= "\t\t\t\t\t'action' => '$meth'" . PHP_EOL;
							$routeScript .= "\t\t\t\t]" . PHP_EOL;
							$routeScript .= "\t\t\t];" . PHP_EOL;
							#}
						}*/
					}/*elseif(in_array($meth, $postRoutes)){

					$routeScript = rtrim($routeScript, ']');
					$routeScript .= "\t," . PHP_EOL . "\t\t\t\t\t" . "'POST' => [" . PHP_EOL . "\t\t\t\t\t\t'controller' => $$crgp," . PHP_EOL . "\t\t\t\t\t\t'action' => '$meth'";
					$routeScript .= PHP_EOL . "\t\t\t\t\t]" . PHP_EOL . "\t\t\t\t]," . PHP_EOL;
					}*/
					#$routeScript .= "\t\t\t\t]";
				}/*else{
				$routeScript .= "\t\t\t\t '$cr/$meth' => [" . PHP_EOL;
				$routeScript .= "\t\t\t\t\t" . 'GET => [' . PHP_EOL . "\t\t\t\t\t\t'controller' => $" . $crgp . PHP_EOL;
				$routeScript .= "\t\t\t\t\t\t" . "'action' => '$meth'" . PHP_EOL . "\t\t\t\t\t ]";
				}*/
				#$routeScript .= "\t\t\t\t]";
			} 
		}
		$routeScript .= PHP_EOL . "\t\t" .'];' .PHP_EOL . "\t\t" . 'return $routes;' . PHP_EOL . "\t}" . PHP_EOL;
		#$routeScript .= "\t}";
		$routeScript .= PHP_EOL . "\tpublic function getAuthentication(): Authentication{" .PHP_EOL . "\t\t return";
		$routeScript .= '$this->authentication;' . PHP_EOL . "\t}" . PHP_EOL;

		$routeScript .= PHP_EOL . "\t" . 'public function checkPermission($permission): bool{' .PHP_EOL . "\t\t" . '$user = ';
		$routeScript .= '$this->authentication->getUser();' . PHP_EOL . PHP_EOL . "\t\t";
		$routeScript .= 'if($user && $user->hasPermission($permission)) {' . PHP_EOL . "\t\t\t" . 'return true;' . PHP_EOL;
		$routeScript .= /*PHP_EOL .*/ "\t\t" . '} else {' . PHP_EOL . "\t\t\t" . 'return false;';
		$routeScript .= PHP_EOL . "\t\t}" . PHP_EOL /*. PHP_EOL . PHP_EOL*/;
		#$routeScript .=  /*"\t}" . PHP_EOL . */"}";

		#$modelName = substr($model->getName(), 6);
		# Write to the file'
		$modelDir = __DIR__ . '/../../keep/model';
		$modelFileUpdate = 'ModelUpdate.php';
		
		if(!file_exists($modelDir)){
			mkdir($modelDir, 0777, true);
			if(chdir($modelDir)){
				file_put_contents($modelFileUpdate, $routeScript);
			}
			#return true;
			"Model" . "<br/>";
		}else{
			if(is_writable($modelDir)){
				chdir($modelDir);
				file_put_contents($modelFileUpdate, $routeScript);
				#return true;
				echo "Mode" . "<br>";
			}else{
				#return false;
				"Module" . "<br/>";
			}
		}

		$routeScript .= "\t}" . PHP_EOL;
		$routeScript .= "}". PHP_EOL;

		# Write to the file'
		$routes_dir = __DIR__ . '/../../';
		$routesFile = 'Routes.php';
		/*if(!file_exists($controller_dir)) {
		mkdir($controller_dir, 0777, true);*/
		if(chdir($routes_dir)){
			file_put_contents($routesFile, $routeScript);
		}
		#return true;
		#}
		return true;
	}
}