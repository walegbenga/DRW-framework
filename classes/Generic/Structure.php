<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 18/07/19
* Time : 21:44
*/

namespace Generic;

class Structure{

	private $pdo;
	#private $db;
	#private $table;
	public function __construct(\PDO $pdo/*DatabaseConnect $db*/){
		$this->pdo = $pdo;
		#$this->db = $db;
	}

	private function generateLoginLayout(){
		echo 'Generating Admin Login page and folder' . "<br/>";
		$loginView = 'login.html.php';

		$loginLayouts = '<?php if(isset($error)):?>' . PHP_EOL . "\t" . '<div class="errors"><?=$error?></div>';
		$loginLayouts .= PHP_EOL . "<?php endif;?>" . PHP_EOL;
		$loginLayouts .= '<div class="form">' . PHP_EOL . "\t" . '<form class="theForm" method="post" action="" accept-charset="utf-8" id="loginForm">';
		$loginLayouts .= PHP_EOL . "\t\t<fieldset>" . PHP_EOL . "\t\t\t<legend>Signin form</legend>";
		$loginLayouts .= PHP_EOL . "\t\t\t<ol>" . PHP_EOL . "\t\t\t\t<li>";
		$loginLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"email\">Email:</label>";
		$loginLayouts .= PHP_EOL . "\t\t\t\t\t" . '<input type="email" id="email" name="email" placeholder="Email address" value="<?=$_POST["email"] ?? ""?>">' . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t<li>";
		$loginLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"password\">Password:</label>";
		$loginLayouts .= PHP_EOL . "\t\t\t\t\t<input type=\"password\" id=\"password\" name=\"password\" value=\"\">" . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t<li>";
		$loginLayouts .= PHP_EOL . "\t\t\t\t\t<input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Login\">" . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL;
		$loginLayouts .= "\t\t\t</ol>" . PHP_EOL . "\t\t\t" . '<p>Forget password?<a href="/admin/forget-password">Click here</a></p>';
		$loginLayouts .= PHP_EOL . "\t\t</fieldset>";
		$loginLayouts .= PHP_EOL . "\t</form>";
		$loginLayouts .= PHP_EOL . "\t</div>";

		$login_dir = __DIR__ . '/../../template/login';
		if(file_exists($login_dir)){
			#mkdir($login_dir, 0777, true);
			if(chdir($login_dir)){
				file_put_contents($loginView, $loginLayouts);
			}
		}
		echo 'Finish generating the admin login files and folder' . "<br/>";
	}

	private function generateLoginRegCss(){
		echo 'Generating Admin Login css and folder' . "<br/>";
		$cssView = 'login.css';

		$cssLayouts = '.theForm{' . PHP_EOL . "\twidth: 300px;" . PHP_EOL . "\tmargin-left: 13%;";
		$cssLayouts .= PHP_EOL . "\tpadding-left: 5px;" . PHP_EOL . "\tborder-left-color: #00b;" . PHP_EOL . "}" . PHP_EOL;
		$cssLayouts .= '.theForm fieldset{' . PHP_EOL . "\tbackground-color: #dd9;" . PHP_EOL . "\tborder: none;";
		$cssLayouts .=  PHP_EOL . "}" . PHP_EOL;
		$cssLayouts .= '.theForm legend{' . PHP_EOL . "\tbackground-color: #dd9;" . PHP_EOL . "\tpadding: 0 auto 0 2px;";
		$cssLayouts .=  PHP_EOL . "}" . PHP_EOL;
		$cssLayouts .= '.theForm ol{' . PHP_EOL . "\tlist-style: none;" . PHP_EOL . "\tmargin: 2px;" . PHP_EOL . "\tpadding: 0;";
		$cssLayouts .=  PHP_EOL . "}" . PHP_EOL;
		$cssLayouts .= '.theForm li{' . PHP_EOL . "\tmargin: 0 0 9px 0;" . PHP_EOL . "\tpadding: 0;";
		$cssLayouts .=  PHP_EOL . "}" . PHP_EOL;
		$cssLayouts .= '.theForm fieldset, .theForm input, .theForm legend{' . PHP_EOL . "\tborder-radius: 7px;";
		$cssLayouts .=  PHP_EOL . "}" . PHP_EOL;
		$cssLayouts .= '.theForm input{' . PHP_EOL . "\tbackground-color: #fff;" . PHP_EOL . "\tborder: 1px solid #bbb;";
		$cssLayouts .= PHP_EOL . "\tdisplay: block;" . PHP_EOL . "\twidth: 200px;" . PHP_EOL .  "\tpadding: 2px;";
		$cssLayouts .=  PHP_EOL . "}" . PHP_EOL;
		$cssLayouts .= '.theForm input[type="submit"]{' . PHP_EOL . "\tbackground-color: #bbb;" . PHP_EOL . "\tpadding: 0;";
		$cssLayouts .= PHP_EOL . "\twidth: 230px;" . PHP_EOL . "\theight: 20px;";
		$cssLayouts .=  PHP_EOL . "}" . PHP_EOL;
		$cssLayouts .= '.theForm input[type="button"], li last-child{' . PHP_EOL . "\tbackground-color: #f00;" . PHP_EOL . "\tpadding: 0;";
		$cssLayouts .= PHP_EOL . "\twidth: 230px;" . PHP_EOL . "\tmargin-top: 2px;" . PHP_EOL . "\theight: 20px;";
		$cssLayouts .=  PHP_EOL . "}" . PHP_EOL;

		$css_dir = __DIR__ . '/../../public/assets/css';
		#$css_dir = __DIR__ . '';
		if(!file_exists($css_dir)){
			mkdir($css_dir, 0777, true);
			if(chdir($css_dir)){
				file_put_contents($cssView, $cssLayouts);
			}
		}
		echo 'Finish generating the admin login css and folder' . "<br/>";
	}

	private function generateAdminLayout(){
		echo 'Generating Admin Registration page and folder' . "<br/>";
		$regView = 'register.html.php';

		$regLayouts = '<?php if(isset($error)):?>' . PHP_EOL . "\t" . '<div class="errors"><?=$error?></div>';
		$regLayouts .= PHP_EOL . "<?php endif;?>" . PHP_EOL;
		$regLayouts .= '<div class="form">' . PHP_EOL . "\t" . '<form class="theForm" method="post" action="" accept-charset="utf-8" id="regForm">';
		$regLayouts .= PHP_EOL . "\t\t<fieldset>" . PHP_EOL . "\t\t\t<legend>Registration form</legend>";
		$regLayouts .= PHP_EOL . "\t\t\t<ol>" . PHP_EOL . "\t\t\t\t<li>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"firstName\">FirstName:</label>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t" . '<input type="text" id="firstName" name="admin[firstName]" placeholder="FirstName here" value="<?=$admin["firstName"] ?? ""?>">' . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t<li>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"lastName\">LastName:</label>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t" . '<input type="text" id="lastName" name="admin[lastName]" placeholder="LastName here" value="<?=$admin["lastName"] ?? ""?>">' . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t<li>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"username\">Username:</label>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t" . '<input type="text" id="username" name="admin[username]" placeholder="Username here" value="<?=$admin["username"] ?? ""?>">' . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t<li>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"email\">Email:</label>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t" . '<input type="text" id="email" name="admin[email]" placeholder="Email address" value="<?=$admin["email"] ?? ""?>">' . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t<li>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"password\">Password:</label>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t<input type=\"password\" id=\"password\" name=\"admin[password]\" value=\"\">" . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t<li>";
		$regLayouts .= PHP_EOL . "\t\t\t\t\t<input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Register\">" . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL;
		$regLayouts .= "\t\t\t</ol>" . PHP_EOL . "\t\t\t" . '<p>Forget password?<a href="/admin/forget-password">Click here</a></p>';
		$regLayouts .= PHP_EOL . "\t\t</fieldset>";
		$regLayouts .= PHP_EOL . "\t</form>";
		$regLayouts .= PHP_EOL . "\t</div>";

		$reg_dir = __DIR__ . '/../../template/admin';
		if(file_exists($reg_dir)){
			#mkdir($reg_dir, 0777, true);
			if(chdir($reg_dir)){
				file_put_contents($regView, $regLayouts);
			}
		}
		echo 'Finish generating the admin registration files and folder' . "<br/>";
	}
	
	private function generateLoginErrorLayout(){
		echo 'Generating Admin Login error page and folder' . "<br/>";
		$loginErrorView = 'loginerror.html.php';

		$loginErrorLayouts = '<h2>You are not logged in</h2>' . PHP_EOL;
		$loginErrorLayouts .= '<p>You must looged in to view this page. <a href="/login/new">Click here to login</a> or <a href="/register/new">Click to register an account</a></p>';

		$loginerror_dir = __DIR__ . '/../../template/login';
		if(file_exists($loginerror_dir)){
			#mkdir($loginerror_dir, 0777, true);
			if(chdir($loginerror_dir)){
				file_put_contents($loginErrorView, $loginErrorLayouts);
			}
		}
		echo 'Finish generating the admin login error files and folder' . "<br/>";
	}

	private function generateLoginSuccessLayout(){
		echo 'Generating Admin Login success page and folder' . "<br/>";
		$loginSuccessView = 'loginsuccess.html.php';

		$loginSuccessLayouts = '<h2>You are now logged in</h2>' . PHP_EOL;
		$loginSuccessLayouts .= '<p>If you are not redirected in 10 secons, please <a href="/">Click here to login</a> </p>';

		$loginsuccess_dir = __DIR__ . '/../../template/login';
		if(!file_exists($loginsuccess_dir)){
			mkdir($loginsuccess_dir, 0777, true);
			if(chdir($loginsuccess_dir)){
				file_put_contents($loginSuccessView, $loginSuccessLayouts);
			}
		}
		echo 'Finish generating the admin login success files and folder' . "<br/>";
	}
	
	private function generateRegSuccessLayout(){
		echo 'Generating Admin register success page and folder' . "<br/>";
		$regSuccessView = 'registersuccess.html.php';

		$regSuccessLayouts = '<h2>Registration successful</h2>' . PHP_EOL;
		$regSuccessLayouts .= '<p>If you are not redirected in 10 secons, please <a href="/login">Click here to login</a> </p>';

		$regsuccess_dir = __DIR__ . '/../../template/admin';
		if(file_exists($regsuccess_dir)){
			#mkdir($regsuccess_dir, 0777, true);
			if(chdir($regsuccess_dir)){
				file_put_contents($regSuccessView, $regSuccessLayouts);
			}
		}
		echo 'Finish generating the admin register success files and folder' . "<br/>";
	}

	private function generateRegHomeLayout(){
		echo 'Generating Admin index success page and folder' . "<br/>";
		$regView = 'home.html.php';

		$regLayouts = '<h2>Welcome to our home page</h2>' . PHP_EOL;
		#$regLayouts .= '<p>If you are not redirected in 10 secons, please <a href="/login">Click here to login</a> </p>';

		$reg_dir = __DIR__ . '/../../template/admin';
		if(file_exists($reg_dir)){
			#mkdir($regsuccess_dir, 0777, true);
			if(chdir($reg_dir)){
				file_put_contents($regView, $regLayouts);
			}
		}
		echo 'Finish generating the admin register index files and folder' . "<br/>";
	}

	private function generateViewMyProfile(){
		echo 'Generating Admin view profile page and folder' . "<br/>";
		$viewMyProfileView = 'viewmyprofile.html.php';

		$viewProfileLayouts = '<h2><?=$title?>("<?=adminProfile->firstName $adminProfile->lastName?>")</h2>' . PHP_EOL;
		$viewProfileLayouts .= '<ul>' . PHP_EOL;
		$viewProfileLayouts .= "\t<li>" . '<?=adminProfile->firstName $adminProfile->lastName?>' . "</li>" . PHP_EOL;
		$viewProfileLayouts .= "\t<li>" . '<?=adminProfile->username?>' . "</li>" . PHP_EOL;
		$viewProfileLayouts .= "\t<li>" . '<?=adminProfile->email?>' . "</li>" . PHP_EOL;
		$viewProfileLayouts .= "</ul>" . PHP_EOL;

		$viewprofile_dir = __DIR__ . '/../../template/admin';
		if(!file_exists($viewprofile_dir)){
			mkdir($viewprofile_dir, 0777, true);
			if(chdir($viewprofile_dir)){
				file_put_contents($viewMyProfileView, $viewProfileLayouts);
			}
		}
		echo 'Finish generating the admin view my profile files and folder' . "<br/>";	
	}
	
	private function generateForegetPasswordLayout(){
		echo 'Generating Forget password page and folder' . "<br/>";
		$fpView = 'forgetpassword.html.php';

		$fpLayouts = '<?php if(isset($error)):?>' . PHP_EOL . "\t" . '<div class="errors"><?=$error?></div>';
		$fpLayouts .= PHP_EOL . "<?php endif;?>" . PHP_EOL;
		$fpLayouts .= '<div class="form">' . PHP_EOL . "\t" . '<form class="theForm" method="post" action="" accept-charset="utf-8" id="loginForm">';
		$fpLayouts .= PHP_EOL . "\t\t<fieldset>" . PHP_EOL . "\t\t\t<legend>Signin form</legend>";
		$fpLayouts .= PHP_EOL . "\t\t\t<ol>" . PHP_EOL . "\t\t\t\t<li>";
		$fpLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"email\">Email:</label>";
		$fpLayouts .= PHP_EOL . "\t\t\t\t\t" . '<input type="text" id="email" name="username" placeholder="Email address" value="<?=$_POST["email"] ?? ""?>">' . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t<li>";
		$fpLayouts .= PHP_EOL . "\t\t\t\t<li>";
		$fpLayouts .= PHP_EOL . "\t\t\t\t\t<input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Send mail\">" . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL;
		$fpLayouts .= PHP_EOL . "\t\t</fieldset>";
		$fpLayouts .= PHP_EOL . "\t</form>";
		$fpLayouts .= PHP_EOL . "</div>";

		$fp_dir = __DIR__ . '/../../template/forgetpassword';
		if(!file_exists($fp_dir)){
			mkdir($fp_dir, 0777, true);
			if(chdir($fp_dir)){
				file_put_contents($fpView, $fpLayouts);
			}
		}
		echo 'Finish generating the admin login files and folder' . "<br/>";
	}
	
	private function generateResetPasswordLayout(){
		echo 'Generating Forget password page and folder' . "<br/>";
		$fpView = 'new.html.php';

		$fpLayouts = '<?php if(isset($error)):?>' . PHP_EOL . "\t" . '<div class="errors"><?=$error?></div>';
		$fpLayouts .= PHP_EOL . "<?php endif;?>" . PHP_EOL;
		$fpLayouts .= '<div class="form">' . PHP_EOL . "\t" . '<form class="theForm" method="post" action="" accept-charset="utf-8" id="loginForm">';
		$fpLayouts .= PHP_EOL . "\t\t<fieldset>" . PHP_EOL . "\t\t\t<legend>Signin form</legend>";
		$fpLayouts .= PHP_EOL . "\t\t\t<ol>" . PHP_EOL . "\t\t\t\t<li>";
		$fpLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"password\">Password:</label>";
		$fpLayouts .= PHP_EOL . "\t\t\t\t\t" . '<input type="password" id="password" name="password" placeholder="Password" value="<?=$_POST["password"] ?? ""?>">' . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t";
		$fpLayouts .= "<li>";
		$fpLayouts .= PHP_EOL . "\t\t\t\t\t<label for=\"password2\">Password2:</label>";
		$fpLayouts .= PHP_EOL . "\t\t\t\t\t" . '<input type="password" id="password2" name="password2" placeholder="Password2" value="">' . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL . "\t\t\t\t";
		$fpLayouts .= "\t\t\t\t<li>";
		$fpLayouts .= PHP_EOL . "\t\t\t\t\t<input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Change password\">" . PHP_EOL . "\t\t\t\t</li>" . PHP_EOL;
		$fpLayouts .= "\t\t\t</ol>";
		$fpLayouts .= PHP_EOL . "\t\t</fieldset>";
		$fpLayouts .= PHP_EOL . "\t</form>";
		$fpLayouts .= PHP_EOL . "</div>";

		$fp_dir = __DIR__ . '/../../template/resetpassword';
		if(!file_exists($fp_dir)){
			mkdir($fp_dir, 0777, true);
			if(chdir($fp_dir)){
				file_put_contents($fpView, $fpLayouts);
			}
		}
		echo 'Finish generating the admin login files and folder' . "<br/>";
	}
	
	private function generateComposer(){
		echo 'Generating composer....' . '<br/>';
		$composerScript = '{' . PHP_EOL;
		$composerScript .= "\t" . '"require": {' . PHP_EOL;
		$composerScript .= "\t}," . PHP_EOL;
		$composerScript .= "\t" . '"autoload": {' . PHP_EOL;
		$composerScript .= "\t\t" . '"psr-4": {' . PHP_EOL;
		$composerScript .= "\t\t\t" . '"Classess\\": "classes/"' . PHP_EOL;
		$composerScript .= "\t\t}" . PHP_EOL;
		$composerScript .= "\t}" . PHP_EOL;
		$composerScript .= "}" . PHP_EOL; 
		
		# Write to the file'
		$composer_dir = __DIR__ . '/../../';
		$composerFile = 'composer.json';
		if(is_writable($composer_dir)){
			if(chdir($composer_dir)){
				if(!file_exists($composerFile)){
					file_put_contents($composerFile, $composerScript);
					#return true;
				}
			}
		}else{
			return false;
		}
		echo 'Finish generating composer...' . '<br/>';
		echo 'Leaving composer' . '<br/>';
		return true;
	}

	private function generateGitIgnore(){
		echo 'Generating .gitignore....' . '<br/>';
		$gitScript = 'vendor/' . PHP_EOL;
		$gitScript .= '.env' . PHP_EOL;
		# Write to the file'
		$git_dir = __DIR__ . '/../../';
		$gitFile = '.gitignore';
		if(is_writable($git_dir)){
			if(chdir($git_dir)){
				if(!file_exists($gitFile)){
					file_put_contents($gitFile, $gitScript);
					#return true;
				}
			}
		}else{
			return false;
		}
		echo 'Finish generating .gitignore...' . '<br/>';
		echo 'Leaving .gitignore' . '<br/>';
		return true;
	}

	private function generateEnv(){
		echo 'Generating environment....' . '<br/>';

		$envScript = 'DB_HOST=localhost' . PHP_EOL;
		$envScript .= 'DB_PORT=3306' . PHP_EOL;
		$envScript .= 'DB_DATABASE=';
		$envScript .= 'DB_USERNAME=' . PHP_EOL;
		$envScript .= 'DB_PASSWORD=' . PHP_EOL;
		# Write to the file'
		$env_dir = __DIR__ . '/../../';
		$envFile = '.env';

		if(is_writable($env_dir)){
			if(chdir($env_dir)){
				if(!file_exists($envFile)){
					file_put_contents($envFile, $envScript);
					#return true;
				}
			}
		}else{
			return false;
		}
		echo 'Finish generating environment...' . '<br/>';
		echo 'Leaving environment' . '<br/>';
		return true;
	}

	private function generateEnvExample(){
		echo 'Generating environment example....' . '<br/>';
		$envexampleScript = 'DB_HOST=localhost' . PHP_EOL;
		$envexampleScript .= 'DB_PORT=3306' . PHP_EOL;
		$envexampleScript .= 'DB_DATABASE=';
		$envexampleScript .= 'DB_USERNAME=' . PHP_EOL;
		$envexampleScript .= 'DB_PASSWORD=' . PHP_EOL;
		# Write to the file'
		$env_example_dir = __DIR__ . '/../../';
		$env_example_File = '.env';
		if(is_writable($env_example_dir)){
			if(chdir($env_example_dir)){
				if(!file_exists($env_example_File)){
					file_put_contents($env_example_File, $envexampleScript);
					#return true;
				}
			}
		}else{
			return false;
		}
		echo 'Finish generating environment example...' . '<br/>';
		echo 'Leaving environment example' . '<br/>';
		return true;
	}

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
		$controllerAPI_dir = __DIR__ . '/../Controllers/Api';
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

	public function addTableToDB($table, $column = []){
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

		$sql = $this->pdo->prepare($query);
		$sql->execute();
		$res = 'DESCRIBE `' . $table . '`';
		$resul = $this->pdo->query($res);
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
		$dir = __DIR__ . '/../Model';
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

	/*public function addTableToDB($table, $column = []){
		$query = 'CREATE TABLE IF NOT EXISTS `' . $table . '` (';
		$query .= 'id  int(11) not null primary key auto_increment,';
		foreach($column as $key => $value){
			$query .= $value . ",";
		}
		$query = rtrim($query, ',');
		$query .= ')';

		$sql = $this->pdo->prepare($query);
		$sql->execute();
		$res = 'DESCRIBE `' . $table . '`';
		$resul = $this->pdo->query($res);
		$result = $resul->fetchAll(\PDO::FETCH_CLASS);

		echo 'Generating the model class';
		
		$join = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*//*" . PHP_EOL;
		$join .= "# Your entity name" . PHP_EOL . "namespace Model;" . PHP_EOL . PHP_EOL;
		$join .= "class " . ucfirst($table) . "{" . PHP_EOL;
		
		foreach($result as $r){
			$join .= "\tpublic $" .$r->Field . ";" . PHP_EOL;
		}
		$join .= PHP_EOL . "# The construction function". PHP_EOL;
		$join .= "\tpublic function __construct() {". PHP_EOL . "\t}" . PHP_EOL . PHP_EOL;
		$join .= "}" . PHP_EOL;

		# Write to the file'
		$dir = __DIR__ . '/../Model';
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
				file_put_contents($file, $join/*, FILE_APPEND*//*);
				return true;
			}else{
				return false;
			}
		}
	}*/

	public function generateAdminDB($column = []){
		echo 'Generating the admin model' . "<br/>";
		if(empty($colum)){
			$this->addTableToDB('admin', ['first_name s:(100) nn:', 'last_name string:(100) nn:' , 'email s:(100) nn:', 'password s:(100) nn:', 'username s:(100) nn:']);
			$pw = password_hash('secret', PASSWORD_DEFAULT);
			$query = 'INSERT INTO `admin`(`first_name`, `last_name`, `email`, `password`, `username`) VALUES ("Willy", "Keysers", "stephenogunbule@example.com", :pw, "robbert_bassham")';
			$parameters = ['pw' => $pw];
			$sql = $this->pdo->prepare($query);
			$sql->execute($parameters);
		}else{
			addTableToDB('admin', $column);
		}

		echo 'FInished generating the admin model' . '<br/>';
	}

	/*public function generateAdminDB($column = []){
		echo 'Generating the admin model' . "<br/>";
		if(empty($colum)){
			$this->addTableToDB('admin', ['first_name varchar(100) not null', 'last_name varchar(100) not null' , 'email varchar(100) not null', 'password varchar(100) not null', 'username varchar(100) not null']);
		}else{
			$this->addTableToDB('admin', $column);
		}
		echo 'FInished generating the admin model' . '<br/>';
	}*/
	
	public function generateController($controllerName){
		$controllerScript = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$controllerScript .= "# Your controller name" . PHP_EOL . "namespace Controllers;" . PHP_EOL . PHP_EOL;
		$controllerScript .= "class " . ucfirst($controllerName) . "Controller{" . PHP_EOL . PHP_EOL;
		$controllerScript .= "# The construction function". PHP_EOL;
		$controllerScript .= "\tpublic function __construct() {". PHP_EOL . "\t}" . PHP_EOL . PHP_EOL;
		$controllerScript .= "# Display form". PHP_EOL;
		$controllerScript .=  "\tpublic function new() {" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Process form". PHP_EOL;
		$controllerScript .= "\tpublic function create() {" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Show a single record". PHP_EOL;
		$controllerScript .= "\tpublic function show() {" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# The home page/ default page". PHP_EOL;
		$controllerScript .= "\tpublic function index() {" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Delete a record". PHP_EOL;
		$controllerScript .= "\tpublic function delete() {" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "}". PHP_EOL;

		# Write to the file'
		$controller_dir = __DIR__ . '/../Controllers';
		$controllerFile = ucfirst($controllerName) .'Controller' . '.php';
		if(!file_exists($controller_dir)){
			mkdir($controller_dir, 0777, true);
			if(chdir($controller_dir)){
				file_put_contents($controllerFile, $controllerScript);
			}
			#return true;
		}else{
			if(is_writable($controller_dir)){
				chdir($controller_dir);
				file_put_contents($controllerFile, $controllerScript);
				
				#	return true;
			}else{
				return false;
			}
		}
		return true;
	}
	
	private function generateLoginController(){
		$controllerScript = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$controllerScript .= "# Your controller name" . PHP_EOL . "namespace Controllers;" . PHP_EOL;
		$controllerScript .= "use\\Generic\\{" . PHP_EOL . "\tAuthentication," . PHP_EOL . "\tDatabaseTable" . PHP_EOL . "};";
		$controllerScript .= PHP_EOL . "class LoginController{" . PHP_EOL;
		$controllerScript .= "\tprivate" .  '$authentication;'. PHP_EOL;
		$controllerScript .= "\t" . 'public function __construct(Authentication $authentication){' . PHP_EOL;
		$controllerScript .= "\t\t" . '$this->authentication = $authentication;' . PHP_EOL;
		$controllerScript .= "\t}". PHP_EOL;
		$controllerScript .= "\t# Display form". PHP_EOL;
		$controllerScript .= "\tpublic function new() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'login/login.html.php', 'title' => 'Login Form'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Process form". PHP_EOL;
		$controllerScript .= "\tpublic function create() {" . PHP_EOL;
		$controllerScript .= "\t\t" . 'if($this->authentication->login($_POST["email"], $_POST["password"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '$_SESSION["email"] = $_POST["email"];' . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'header("location: /login/success");' . PHP_EOL;
		$controllerScript .= "\t\t}else{" . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'return [' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'template'=> 'login/login.html.php'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'title'=> 'Login'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'variables'=> [" . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . "'error'=> 'invalid email/password'" . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "]" . PHP_EOL;
		$controllerScript .= "\t\t\t" . "];" . PHP_EOL;
		$controllerScript .= "\t\t" . "}" . PHP_EOL;
		$controllerScript .= "\t" . "}" . PHP_EOL;
		$controllerScript .= "\t# success form" . PHP_EOL;
		$controllerScript .= "\tpublic function show() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'login/loginsuccess.html.php', 'title' => 'Login successful'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\tpublic function error() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'login/loginerror.html.php', 'title' => 'You are not logged in'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\tpublic function permissionsError() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'login/permissionserror.html.php', 'title' => 'Access Denied'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Logout". PHP_EOL;
		$controllerScript .= "\tpublic function delete() {" . PHP_EOL;
		$controllerScript .= "\t\t" . 'unset($_SESSION);' . PHP_EOL;
		$controllerScript .= "\t\t" . 'session_destroy();' . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'home.html.php', 'title' => 'You are logged out'];" . PHP_EOL . "\t}" . PHP_EOL . '}';
		
		# Write to the file'
		$loginController_dir = __DIR__ . '/../Controllers';
		$loginControllerFile = 'LoginController.php';
		if(!file_exists($loginController_dir)){
			mkdir($loginController_dir, 0777, true);
			if(chdir($loginController_dir)){
				file_put_contents($loginControllerFile, $controllerScript);
			}
			#return true;
		}else{
			if(is_writable($loginController_dir)){
				chdir($loginController_dir);
				file_put_contents($loginControllerFile, $controllerScript);
				
				#	return true;
			}else{
				return false;
			}
		}
		return true;
	}
	private function generateRegisterController(){
		$controllerScript = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$controllerScript .= "# Your controller name" . PHP_EOL . "namespace Controllers;" . PHP_EOL;
		$controllerScript .= "use\\Generic\\{" . PHP_EOL . "\tAuthentication," . PHP_EOL . "\tDatabaseTable" . PHP_EOL . "};";
		$controllerScript .= PHP_EOL . "class RegisterController{" . PHP_EOL;
		$controllerScript .= "\tprivate" .  '$adminsTable;'. PHP_EOL;
		$controllerScript .= "\tprivate" .  '$authentication;'. PHP_EOL;
		$controllerScript .= "\t" . 'public function __construct(DatabaseTable $adminsTable, Authentication $authentication){' . PHP_EOL;
		$controllerScript .= "\t\t" . '$this->authentication = $authentication;' . PHP_EOL;
		$controllerScript .= "\t\t" . '$this->adminsTable = $adminsTable;' . PHP_EOL;
		$controllerScript .= "\t}". PHP_EOL;
		$controllerScript .= "\t# Display form". PHP_EOL;
		$controllerScript .= "\tpublic function new() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'admin/register.html.php', 'title' => 'Admin Registration Form'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Process form". PHP_EOL;
		$controllerScript .= "\tpublic function create() {" . PHP_EOL;
		$controllerScript .= "\t\t" . 'if(isset($_POST["submit"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '$admin = $_POST["admin"];' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '$valid = true;' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '$errors = [];' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($admin["firstName"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "FirstName can not be empty";' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '}' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($admin["lastName"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "LastName can not be empty";' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '}' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($admin["username"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "username can not be empty";' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '}else{' . PHP_EOL;
		$controllerScript .=  "\t\t\t\t" . '$admin[\'username\'] = strtolower($admin["username"]);' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'if(count($this->adminsTable->find("username", $admin["username"])) > 0){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$errors[] = "Username is already taken";' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '}' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t}" . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($admin["email"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "email can not be empty";' . PHP_EOL;
		$controllerScript .= "\t\t\t}" . 'else if(filter_var($admin["email"], FILTER_VALIDATE_EMAIL) == false){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "Invalid email address";' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '}else{' . PHP_EOL;
		$controllerScript .=  "\t\t\t\t" . '$admin[\'email\'] = strtolower($admin["email"]);' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'if(count($this->adminsTable->find("email", $admin["email"])) > 0){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$errors[] = "Email already registered";' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '}' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t}" . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($admin["password"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "Password can not be blank";' . PHP_EOL;
		$controllerScript .= "\t\t\t}" . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if($valid == true){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$admin["password"] = password_hash($admin["password"], PASSWORD_DEFAULT);' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$this->adminsTable->save($admin);' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'header("location: /register/success");' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'exit();' . PHP_EOL;
		$controllerScript .= "\t\t\t}" . PHP_EOL;
		$controllerScript .= "\t\t}else{" . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'return [' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'template'=> 'admin/register.html.php'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'title'=> 'Registration form'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'variables'=> [" . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '"errors"=> $errors,' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '"admin" => $admin' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "]" . PHP_EOL;
		$controllerScript .= "\t\t\t" . "];" . PHP_EOL;
		$controllerScript .= "\t\t" . "}" . PHP_EOL;
		$controllerScript .= "\t" . "}" . PHP_EOL;

		$controllerScript .= "\t# Process edit form". PHP_EOL;
		$controllerScript .= "\tpublic function update() {" . PHP_EOL;
		$controllerScript .= "\t\t" . 'if(isset($_POST["submit"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '$admin = $_POST["admin"];' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '$valid = true;' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '$errors = [];' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($admin["firstName"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "FirstName can not be empty";' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '}' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($admin["lastName"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "LastName can not be empty";' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '}' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($admin["password"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "Password can not be blank";' . PHP_EOL;
		$controllerScript .= "\t\t\t}" . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if($valid == true){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$admin["password"] = password_hash($admin["password"], PASSWORD_DEFAULT);' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$this->adminsTable->save(admin);' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'header("location: /");' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'exit();' . PHP_EOL;
		$controllerScript .= "\t\t\t}" . PHP_EOL;
		$controllerScript .= "\t\t}else{" . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'return [' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'template'=> 'admin/editprofile.html.php'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'title'=> 'Edit profile page'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'variables'=> [" . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '"errors"=> $errors,' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '"admin"=> $admin' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "]" . PHP_EOL;
		$controllerScript .= "\t\t\t" . "];" . PHP_EOL;
		$controllerScript .= "\t\t" . "}" . PHP_EOL;
		$controllerScript .= "\t" . "}" . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t# Viewing your profile" . PHP_EOL;
		$controllerScript .= "\t" . 'public function show(){' . PHP_EOL;
		$controllerScript .= "\t\t" . '$adminProfile = $this->authentication->getUser();' . PHP_EOL;
		$controllerScript .= "\t\t" . 'return [' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '"template" => "admin/viewmyprofile.html.php",' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '"title" => "Viewing your profile",' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '"variables" => [' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '"adminProfile" => $adminProfile' . PHP_EOL;
		$controllerScript .= "\t\t\t" . ']' . PHP_EOL;
		$controllerScript .= "\t\t" . '];' . PHP_EOL;
		$controllerScript .= "\t" . '}' . PHP_EOL;
		$controllerScript .= "\t# success form" . PHP_EOL;
		$controllerScript .= "\tpublic function success() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'admin/registersuccess.html.php', 'title' => 'Registration Successful'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# List all admins". PHP_EOL;
		$controllerScript .= "\tpublic function list() {" . PHP_EOL;
		$controllerScript .= "\t\t" . '$admins = $this->adminsTable->findAll();' . PHP_EOL;
		$controllerScript .= "\t\t" . '$title = "All admin lists";' . PHP_EOL;
		$controllerScript .= "\t\treturn [" . PHP_EOL;
		$controllerScript .= "\t\t\t" . "'template' => 'admin/home.html.php'," . PHP_EOL;
		$controllerScript .= "\t\t\t" . "'title' => 'You are logged out'," . PHP_EOL;
		$controllerScript .= "\t\t\t" . "'variables' =>[" . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '"admins" => $admins' . PHP_EOL;
		$controllerScript .= "\t\t\t]" . PHP_EOL;
		$controllerScript .= "\t\t];" . PHP_EOL;
		$controllerScript .= "\t}" . PHP_EOL;
		$controllerScript .= '}';
		
		# Write to the file'
		$regController_dir = __DIR__ . '/../Controllers';
		$regControllerFile = 'RegisterController.php';
		if(!file_exists($regController_dir)){
			mkdir($regController_dir, 0777, true);
			if(chdir($regController_dir)){
				file_put_contents($regControllerFile, $controllerScript);
			}
			#return true;
		}else{
			if(is_writable($regController_dir)){
				chdir($regController_dir);
				file_put_contents($regControllerFile, $controllerScript);
				
				#	return true;
			}else{
				return false;
			}
		}
		return true;
	}
	
	public function generateFPController(){
		$controllerScript = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$controllerScript .= "# Your controller name" . PHP_EOL . "namespace Controllers;" . PHP_EOL;
		$controllerScript .= "use\\Generic\\{" . PHP_EOL . "\tAuthentication," . PHP_EOL . "\tDatabaseTable" . PHP_EOL . "};";
		$controllerScript .= PHP_EOL . "class ForgetPasswordController{" . PHP_EOL;
		$controllerScript .= "\tprivate" .  '$usersTable;'. PHP_EOL;
		$controllerScript .= "\tprivate" .  '$accessTokensTable;'. PHP_EOL;
		$controllerScript .= "\t" . 'public function __construct(DatabaseTable $usersTable, DatabaseTable $accessTokensTable){' . PHP_EOL;
		$controllerScript .= "\t\t" . '$this->usersTable = $usersTable;' . PHP_EOL;
		$controllerScript .= "\t\t" . '$this->accessTokensTable = $accessTokensTable;' . PHP_EOL;
		$controllerScript .= "\t}". PHP_EOL;
		$controllerScript .= "\t# Display form". PHP_EOL;
		$controllerScript .= "\tpublic function new() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'forgetpassword/forgetpassword.html.php', 'title' => 'Forget password Form'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Process form". PHP_EOL;
		$controllerScript .= "\tpublic function create() {" . PHP_EOL;
		$controllerScript .= "\t\t" . 'if(isset($_POST["submit"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($_POST["email"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "email can not be empty";' . PHP_EOL;
		$controllerScript .= "\t\t\t}" . 'else if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "Invalid email address";' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '}else{' . PHP_EOL;
		$controllerScript .=  "\t\t\t\t" . '$_POST[\'email\'] = strtolower($_POST["email"]);' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'if(count($this->adminsTable->find("email", $_POST["email"])) < 1){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$errors[] = "The email address does not exist in our database";' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '}' . PHP_EOL . "\t\t\t}" . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . '$user = $this->usersTable->find("email", $_POST["email"]);' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if($valid == true){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$token = open_ssl_random_pseudo_bytes(32);' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$token = bin2hex($token);' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'foreach($user as $u){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$theUser = [' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t\t" . '"id" => $u->id,' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t\t" . '"token" => $token,' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t\t" . '"dateExpires" => "DATE_ADD(NOW(), INTERVAL 15 MINUTE)"' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '];' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$fpModel = $this->usersTable->save($theUser);' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$fpModel->sendMsg($msg);' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'return [' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . "'template'=> 'forgetpassword/show.html.php'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . "'title'=> 'Password reset sent to your email address'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . "'variables'=> [" . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t\t" . '"response"=> $response' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . "]" . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "];" . PHP_EOL;
		$controllerScript .= "\t\t\t" . "}" . PHP_EOL;
		$controllerScript .= "\t\t}" . PHP_EOL;
		$controllerScript .= "\t}else{" . PHP_EOL;
		$controllerScript .= "\t\t" . 'return [' . PHP_EOL;
		$controllerScript .= "\t\t\t" . "'template'=> 'forgetpassword/forgetpassword.html.php'," . PHP_EOL;
		$controllerScript .= "\t\t\t" . "'title'=> 'Email not found'," . PHP_EOL;
		$controllerScript .= "\t\t\t" . "'variables'=> [" . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'error'=> 'The email address does not match any email address we have in our database.'" . PHP_EOL;
		$controllerScript .= "\t\t\t" . "]" . PHP_EOL;
		$controllerScript .= "\t\t" . "];" . PHP_EOL;
		$controllerScript .= "\t" . "}" . PHP_EOL;
		$controllerScript .= "\t" . "}" . PHP_EOL;
		$controllerScript .= "\t# success form" . PHP_EOL;
		$controllerScript .= "\t" . 'public function show() {' . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'forgetpassword/show.html.php', 'title' => 'Email sent successfully'];" . PHP_EOL . "\t}" . PHP_EOL;
		/*$controllerScript .= "\tpublic function error() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'login/loginerror.html.php', 'title' => 'You are not logged in'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\tpublic function permissionsError() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'login/permissionserror.html.php', 'title' => 'Access Denied'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Logout". PHP_EOL;
		$controllerScript .= "\tpublic function logout() {" . PHP_EOL;
		$controllerScript .= "\t\t" . 'unset($_SESSION);' . PHP_EOL;
		$controllerScript .= "\t\t" . 'session_destroy();' . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'home.html.php', 'title' => 'You are logged out'];" . PHP_EOL . "\t}" . PHP_EOL . '}';*/
		$controllerScript .= PHP_EOL . '}';
		
		# Write to the file'
		$ForgetPasswordController_dir = __DIR__ . '/../Controllers';
		$ForgetPasswordControllerFile = 'ForgetPasswordController.php';
		if(file_exists($ForgetPasswordController_dir)) {
			#mkdir($ForgetPasswordController_dir, 0777, true);
				if(chdir($ForgetPasswordController_dir)){
					file_put_contents($ForgetPasswordControllerFile, $controllerScript);
				}
			#return true;
		}else{
			if(is_writable($ForgetPassweordController_dir)){
				chdir($ForgetPasswordController_dir);
				file_put_contents($ForgetPasswordControllerFile, $controllerScript);
				
			#	return true;
			}else{
				return false;
			}
		}
		return true;
	}
	
	public function generateRPController(){
		$this->generateResetPasswordLayout();
		$controllerScript = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$controllerScript .= "# Your controller name" . PHP_EOL . "namespace Controllers;" . PHP_EOL;
		$controllerScript .= "use\\Generic\\{" . PHP_EOL . "\tAuthentication," . PHP_EOL . "\tDatabaseTable" . PHP_EOL . "};";
		$controllerScript .= PHP_EOL . "class ResetPasswordController{" . PHP_EOL;
		$controllerScript .= "\tprivate" .  '$usersTable;'. PHP_EOL;
		$controllerScript .= "\t" . 'public function __construct(DatabaseTable $usersTable){' . PHP_EOL;
		$controllerScript .= "\t\t" . '$this->usersTable = $usersTable;' . PHP_EOL;
		$controllerScript .= "\t}". PHP_EOL;
		$controllerScript .= "\t# Display form". PHP_EOL;
		$controllerScript .= "\tpublic function new() {" . PHP_EOL;
		$controllerScript .= "\t\t" . 'if(isset($_GET[\'t\']) && (strlen($_GET[\'t\']) == 64)){' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '$resetToken = $this->accessToken->find("token", $_GET["t"]);' . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(count($resetToken > 0)){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'foreach($resetToken as $rt){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$tokenId = $rt->userId;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '}' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '}' . PHP_EOL;
		$controllerScript .= "\t\t" . '}' . PHP_EOL;
		$controllerScript .= "\t\t" . 'return [\'template\' => \'resetpassword/new.html.php\', \'title\' => \'Password Reset form\', \'variables\' => [\'tokenid\' => $tokenId]];' . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= "\t# Process form". PHP_EOL;
		$controllerScript .= "\tpublic function create() {" . PHP_EOL;
		$controllerScript .= "\t\t" . '$valid = true;' . PHP_EOL;
		$controllerScript .= "\t\t" . '$errors = [];' . PHP_EOL;
		$controllerScript .= "\t\t" . 'if(isset($_POST["submit"]) && $_POST["userId"]){' . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'if(empty($_POST["password"])){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "password can not be empty";' . PHP_EOL;
		$controllerScript .= "\t\t\t}" . 'else if(strlen($_POST["password"]) <= 5){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$valid = false;' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '$errors[] = "Invalid email address";' . PHP_EOL;
		$controllerScript .= "\t\t\t" . '}else{' . PHP_EOL;
		#$controllerScript .=  "\t\t\t\t" . '$_POST[\'email\'] = strtolower($_POST["email"]);' . PHP_EOL . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . 'if($_POST["password2"] === $_POST["password"]){' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$user = ["id" => $_POST["userId"], "password" => $_POST["password"]];' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$this->usersTable->save($user);' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$header("location: /login");' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . 'exit();' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . '}else{' . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '$errors[] = "Password combination not correct.";' . PHP_EOL;
		$controllerScript .= "\t\t\t\t}" . PHP_EOL;
		$controllerScript .= "\t\t\t}" . PHP_EOL;
		$controllerScript .= "\t\t}else{" . PHP_EOL;
		$controllerScript .= "\t\t\t" . 'return [' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'template'=> 'resetpassword/new.html.php'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'title'=> 'Reset Password'," . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "'variables'=> [" . PHP_EOL;
		$controllerScript .= "\t\t\t\t\t" . '"error" => $errors' . PHP_EOL;
		$controllerScript .= "\t\t\t\t" . "]" . PHP_EOL;
		$controllerScript .= "\t\t\t" . "];" . PHP_EOL;
		$controllerScript .= "\t\t" . "}" . PHP_EOL;
		$controllerScript .= "\t" . "}" . PHP_EOL;
		$controllerScript .= "\t# success form" . PHP_EOL;
		$controllerScript .= "\tpublic function show() {" . PHP_EOL;
		$controllerScript .= "\t\treturn ['template' => 'resetpassword/show.html.php', 'title' => 'Email sent successfully'];" . PHP_EOL . "\t}" . PHP_EOL;
		$controllerScript .= PHP_EOL . '}';
		
		# Write to the file'
		$ResetPasswordController_dir = __DIR__ . '/../Controllers';
		$ResetPasswordControllerFile = 'ResetPasswordController.php';
		if(file_exists($ResetPasswordController_dir)) {
			#mkdir($ForgetPasswordController_dir, 0777, true);
				if(chdir($ResetPasswordController_dir)){
					file_put_contents($ResetPasswordControllerFile, $controllerScript);
				}
			#return true;
		}else{
			if(is_writable($ResetPassweordController_dir)){
				chdir($ResetPasswordController_dir);
				file_put_contents($ResetPasswordControllerFile, $controllerScript);
				
			#	return true;
			}else{
				return false;
			}
		}
		return true;
	}
	
	public function generateFPModel($siteAddr){
		$this->generateFPController();
		$this->generateForegetPasswordLayout();
		$this->addTableToDB('access_token', ['userId int(11) not null', 'token varchar(150) not null', 'dateExpires datetime not null default current_timestamp']);
		echo 'Generating theForget Password model class' . "<br/>";
		
		$join = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$join .= "# Your entity name" . PHP_EOL . "namespace Model;" . PHP_EOL;
		$join .= "class ForgetPassword{" . PHP_EOL;

		$join .= "\tpublic function __construct(){" . PHP_EOL;
		$join .= "\t\t" . PHP_EOL;
		$join .= "\t}" . PHP_EOL;
		$join .= "\t" . 'public function sendMsg($token){' . PHP_EOL;
		$join .= "\t\t" . '$url =' . "\"$siteAddr?t=\"" . '. $token;' . PHP_EOL;
		$join .= "\t\t" . '$body = ' . '"This email is in response to a forgotten password reset request at $siteAddr. If you did make this request, click the following link to be able to access your account: " . $url;' . PHP_EOL;
		$join .= "\t\t" . '$body .="For security purposes, you have 15 minutes to do this. If you do not click this link within 15 minutes, you will need to request a password reset again. If you have _not_ forgotten your password, you can safely ignore this message and you will still be able to login with your existing password. ";' . PHP_EOL . PHP_EOL;
		$join .= "\t\t" . 'mail($_POST["email"], "Password reset for $siteAddr", $body, "FROM: " . CONTACT_EMAIL);';
		$join .= PHP_EOL . "\t}" . PHP_EOL;
		$join .= PHP_EOL . "}" . PHP_EOL;
		# Write to the file'
		$dir = __DIR__ . '/../Model';
		$file = 'ForgetPassword.php';
		
		if(file_exists($dir)) {
			#mkdir($dir, 0777, true);
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
	
	private function createCacheFolder(){
		$cache_dir = __DIR__ . '/../../cache';
		if(!file_exists($cache_dir)){
			if(mkdir($cache_dir, 0777, true)){
				echo 'cache directory created' . "<br/>";
			}else{
				echo "Unable to create directory" . "<br/>";
			}
		}
		return;
	}

	public function scaffold($table, $column = [], $cache = false){
		
		echo 'Creating the Database Table' . "<br>";
		$this->addTableToDB(lcfirst($table), $column);

		echo 'Creating the controller class' . "<br>";
		$this->generateController($table);
	
		echo 'Generating the login controller file' . '<br/>';
		$this->generateLoginController();
		echo 'Finished generating the login controller file' . '<br/>';

		echo 'Generating the Admin registration controller file' . '<br/>';
		$this->generateRegisterController();
		echo 'Finished generating the registration controller file' . '<br/>';
		
		$this->generateAdminDB();
		
		if($cache == true){
			echo 'Creating cache directory';
			$this->createCacheFolder();
		}
		
		$this->generateComposer();
		$this->generateGitIgnore();
		$this->generateEnv();
		$this->generateEnvExample();

		echo 'Creating view or template' . "<br>";
		$newView = 'new.html.php';
		$indexView = 'index.html.php';
		$editView = 'edit.html.php';
		$showView = 'show.html.php';
		$layoutsView = 'application.html.php';

		$templateNew = '<h2> ' . $table . ' view </h2>' . PHP_EOL;
		$templateNew .= '<p> new form </p>';

		$templateIndex = '<h2> ' . $table . ' view </h2>' . PHP_EOL;
		$templateIndex .= '<p> Index page </p>';

		$templateEdit = '<h2>' . $table . ' view </h2>' . PHP_EOL;
		$templateEdit .= '<p> Edit page </p>';

		$templateShow = '<h2>' . $table . ' view </h2>' . PHP_EOL;
		$templateShow .= '<p> Edit page </p>';

		$templateLayouts = '<!doctype html>' . PHP_EOL . '<html>' . PHP_EOL . "\t<head>" .PHP_EOL . "\t\t<title>";
		$templateLayouts .= '<?=$title?></title>' . PHP_EOL . "\t\t<meta charset='utf-8'>" . PHP_EOL;
		$templateLayouts .= "\t\t" . '<link rel="stylesheet" type="text/css" href="/assets/css/login.css">';
		$templateLayouts .= PHP_EOL . "\t</head>" . PHP_EOL . "\t<body>" . PHP_EOL;
		$templateLayouts .= "\t\t" . '<?= $output ?>' . PHP_EOL . "\t</body>" . PHP_EOL . "</html>";

		$view = [$newView => $templateNew, $indexView => $templateIndex, $editView => $templateEdit, $showView => $templateShow];
		$template_dir = __DIR__ . '/../../template/' . lcfirst($table);
		if(!file_exists($template_dir)){
			mkdir($template_dir, 0777, true);
			if(chdir($template_dir)){
				foreach($view as $k => $v){
					var_dump(file_put_contents($k, $v));
				}
				$layout_dir = __DIR__ . '/../../template/layouts';
				if(!file_exists($layout_dir)){
					mkdir($layout_dir, 0777, true);
					if(chdir($layout_dir)){
						file_put_contents($layoutsView, $templateLayouts);
					}
				}
					
				$this->generateLoginSuccessLayout();
				$this->generateLoginErrorLayout();
				$this->generateLoginLayout();
				#$this->generateLoginLayout();
				$this->generateViewMyProfile();
				$this->generateAdminLayout();
				$this->generateRegSuccessLayout();
				$this->generateRegHomeLayout();
				$this->generateViewMyProfile();
				$this->generateLoginRegCss();

			}
			#return true;
		}else{
			if(is_writable($template_dir)){
				chdir($template_dir);
				file_put_contents($newView, $templateNew);
				file_put_contents($indexView, $templateIndex);
				
				#	return true;
			}else{
				return false;
			}
		}
		return true;
	}

	public function deScaffold($table){
		echo "Deleting $table....." . "<br/>";
		$t = $table;
		
		dropTable($t);
		if($t){
			echo "Successfully delete $t";
		}

		echo "Deleting Model class " . ucfirst($table) . "....";
		delModel(__DIR__ . '/../Model', ucfirst($table) . '.php');

		echo "Deleting Controller class ucfirst($table)" . "Controller";
		delController(__DIR__ . '/../Controllers', ucfirst($table) . 'Controller.php');
		
		echo "Deleting template $table...." . "<br/>";
		dropTemp(__DIR__ . '/../../template/' . $table);
		echo "Successfully delete $table..." . "<br/>";
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

	public function dropTemp($dir){
		if($dh = @opendir($dir)){
			/* Iterate through directory contents. */
			while(($file = readdir($dh)) != false){
				if(($file == ".") || ($file == "..")) continue;
				if(is_dir($dir . '/' . $file))
				$this->deleteTemp($dir . '/' . $file);
				else
				unlink($dir . '/' . $file);
			}

			@closedir($dh);
			rmdir($dir);
		}
	}

	public function delModel($dir, $file){
		$dh = opendir($dir);
		while($data = readdir($dh)){
			if($data == $file){
				unlink($dir . '/' . $file);
				@closedir($data);
			}
		}
	}

	public function delController($dir, $file){
		$dh = opendir($dir);
		while($data = readdir($dh)){
			if($data == $file){
				unlink($dir . '/' . $file);
				@closedir($data);
			}
		}
	}

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

	/*
	private function generateEntryPoint(){
	$epScript = "<?php" . PHP_EOL . "declare(strict_types=1);" . PHP_EOL . PHP_EOL;
	$epScript .= "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*//*" . PHP_EOL;
	$epScript .= PHP_EOL . "namespace Generic" . PHP_EOL . "# Get all controllers" . PHP_EOL;
		
	$epScript .= "class EntryPoint{" . PHP_EOL . PHP_EOL;
	$epScript .= "\t" . 'private $route;' . PHP_EOL . "\t" . 'private $method;' . PHP_EOL;
	$epScript .= "\t" . 'private $routes;' . PHP_EOL;
	$epScript .= "\t# The constructor function". PHP_EOL;
	$epScript .=  "\t" . 'public function __construct(string $route, string $method, \Generic\Routes $routes) {';
	$epScript .= PHP_EOL . PHP_EOL;
	$epScript .= "\t\t" . '$this->route = $route;' . PHP_EOL . "\t\t" . '$this->routes = $routes;' . PHP_EOL;
	$epScript .= "\t\t" . '$this->method = $method;' . PHP_EOL . "\t\t" . '$this->checkUrl();' . PHP_EOL;
	$epScript .= "\t\t" . '$this->cleanUrlText();' . PHP_EOL . "\t}";

	$epScript .= PHP_EOL . "\tprivate function checkUrl() {" .PHP_EOL;
	$epScript .= "\t\t" . 'if ($this->route !== strtolower($this->route)) {' . PHP_EOL;
	$epScript .= "\t\t\thttp_response_code(301);" . "\t\t\t" . PHP_EOL;
	$epScript .= "\t\t\t" . 'header("location: " . strtolower($this->route));';
	$epScript .= "\t\t}" . PHP_EOL . "\t}" . PHP_EOL . PHP_EOL; 

	$epScript .= PHP_EOL . "\tprivate function cleanUrlText() {" .PHP_EOL;
	$epScript .= "\t\t#Remove all characters that aren't a-z, 0-9, dash, underscore or space" . PHP_EOL;
	$epScript .= "\t\t$not_acceptable_characters_regex = '#[^-a-zA-Z0-9_ /]#';" . PHP_EOL;
	$epScript .= "\t\t" . '$this->route = preg_replace($not_acceptable_characters_regex, "", $this->route);' . PHP_EOL;
	$epScript .= "\t\t#Remove all leading and trailing spaces" . PHP_EOL;
	$epScript .= '$this->route = trim($this->route);' . PHP_EOL . "\t\t#Change all dashes, underscores and spaces to dashes";
	$epScript .= "\t\t" . '$this->route = preg_replace(' . "#[-_ ]+#', '-', " . '$this->route);' . PHP_EOL;
	$epScript .= "# Return the modified string" . PHP_EOL . "\t\t" . 'return strtolower($this->routes);'
	$epScript .= "\t}";

	$epScript .= PHP_EOL . "\tprivate function loadTemplate($templateFileName, $variables = []) {" .PHP_EOL;
	$epScript .= "\t\textract($variables);" . PHP_EOL . PHP_EOL;
	$epScript .= "\t\tob_start();" . PHP_EOL;
	$epScript .= "\t\t" . 'require __DIR__ . "/../../templates/" . $templateFileName;' . PHP_EOL;
	$epScript .= "\t\treturn ob_get_clean();" . PHP_EOL;
	$epScript .= "\t}";		

	$epScript .= PHP_EOL . "\public function run() {" .PHP_EOL;
	$epScript .= "\t\t" . '$routes = $this->routes->getRoutes();' . PHP_EOL . "\t\t";
	$epScript .= '$authentication = $this->routes->getAuthentication();' . PHP_EOL . "\t\t";
	$epScript .= 'if (isset($routes[$this->route]['login']) && !$authentication->isLoggedIn()) {' . PHP_EOL . "\t\t\t";
	$epScript .= "header('location: /login/error');" . PHP_EOL . "\t\t}else if";
	$epScript .= '(isset($routes[$this->route][\'permissions\']) && !$this->routes->checkPermission($routes[$this->route][\'permissions\'])) {' .PHP_EOL . "\t\t\t";
	$epScript .= "header('location: /login/permissionerror');" . PHP_EOL . "\t\t}else{";
	$epScript .= "\t\t\t" . '$controller = $routes[$this->route][$this->method][\'controller\'];' . PHP_EOL;
	$epScript .= "\t\t\t" . '$action = $routes[$this->route][$this->method][\'action\'];' . PHP_EOL;
	$epScript .= "\t\t\t" . '$page = $controller->$action();' . PHP_EOL;
	$epScript .= "\t\t\t" . '$page = $controller->$action();' . PHP_EOL;
	$epScript .= "\t\t\t" . '$title = $page[\'title\'];' . PHP_EOL;
	$epScript .= "\t\t\t" . 'if (isset($page[\'variables\'])) {' . PHP_EOL;
	$epScript .= "\t\t\t\t" . '$output = $this->loadTemplate($page[\'template\'], $page[\'variables\']);' . PHP_EOL;
	$epScript .= "\t\t\t" . '}else{' . PHP_EOL;
	$epScript .= "\t\t\t\t" . '$output = $this->loadTemplate($page[\'template\']);' . PHP_EOL;
	$epScript .= "\t\t\t" . '}' . PHP_EOL;
	$epScript .= "\t\t\t" . 'echo $this->loadTemplate(\'layout.html.php\', [\'loggedIn\' => $authentication->isLoggedIn(), \'output\' => $output, \'title\' => $title]);' . PHP_EOL;
	$epScript .= "\t\t}" . PHP_EOL . "\t}" . PHP_EOL . "}";
	$epScript .= "\t}";


	}
	*/
}