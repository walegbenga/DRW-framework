<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 05/04/20
* Time : 17:36
*/

namespace Generic\Console\Controller;

class GenerateController
{
	public function generateController($controllerName){
		$cur_dir = getcwd();
		$controllerScript = "<?php" . PHP_EOL . "/**" . PHP_EOL . "* Document your script" . PHP_EOL . "*/" . PHP_EOL;
		$controllerScript .= "# Your controller name" . PHP_EOL . "namespace App\Controllers;" . PHP_EOL . PHP_EOL;
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
		
		$controller_dir = getcwd() . '/app/Controllers';
		#echo "$controller_dir $controllerName\n\n\n\n\n\n\n\n";
		$controllerFile = ucfirst($controllerName) .'Controller' . '.php';
		if(!file_exists($controller_dir)){
			mkdir($controller_dir, 0777, true);
			if(chdir($controller_dir)){
				file_put_contents($controllerFile, $controllerScript);
			}
			chdir($cur_dir);
			return true;
		}else{
			if(is_writable($controller_dir)){
				chdir($controller_dir);
				file_put_contents($controllerFile, $controllerScript);
				chdir($cur_dir);
				return true;
			}else{
				$type = "Failed.";
				return false;
			}
		}
		$type = "Success.";
		return true;
	}

	public function generateFPController(){
		$cur_dir = getcwd();
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
		$ForgetPasswordController_dir = getcwd() . '/app/Controllers';
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
		$ResetPasswordController_dir = getcwd() . '/app/Controllers';
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
		$dir = getcwd() . '/app';
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

	public function delController( $file){
		$file = ucfirst($file . "Controller.php");
		echo "Deleting $file...\n";
		if(is_dir(getcwd() . "/app/Controllers"))
			if(chdir(getcwd() . "/app/Controllers"))
				unlink( $file);
			else
				echo "Unable to access the directory\n";
		else
			echo "The directory does not exist\n";
	}
}