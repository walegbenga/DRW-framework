<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 05/04/20
* Time : 17:53
*/

namespace Generic\Console\Scaffold;

use \Generic\Console\Database\GenerateDBModel;
use \Generic\Console\Controller\GenerateController;
use \Generic\Console\Templates\TemplateGenerator;
use \Generic\Console\Util\Utility;

class GenerateScaffold
{
    private $pdo;
    private $controller;
    private $template;
    private $utility;
    private $dbModel;
    #private $dry;
    
    public function __construct(/*PDO $pdo*/)
    {
        include __DIR__ . '/../../Database/includes/DatabaseConnection.php';
        $this->controller = new GenerateController();
        $this->template = new TemplateGenerator();
        $this->utility = new Utility();
        $this->dbModel = new GenerateDBModel($pdo);
        #$this->dry = getcwd();
    }

    private function returnCwd(){
    	$cwd = getcwd();
    	return chdir($cwd);
    }

    public function scaffold($table, $column = [], $cache = false)
    {
    	$cwd = getcwd();
    	echo "$cwd...2\n";
        echo 'Creating the Database Table' . PHP_EOL;
        $this->dbModel->addTableToDB(lcfirst($table), $column);

        echo 'Creating the controller class' . PHP_EOL;
        chdir($cwd);
        #$this->returnCwd();
        $this->controller->generateController($table);
    
        echo 'Generating the login controller file' . PHP_EOL;
        chdir($cwd);
        #$this->returnCwd();
        $this->generateLoginController();
        echo 'Finished generating the login controller file' . PHP_EOL;

        echo 'Generating the Admin registration controller file' . PHP_EOL;
        chdir($cwd);
        #$this->returnCwd();
        $this->generateRegisterController();
        echo 'Finished generating the registration controller file' . PHP_EOL;
        #chdir(getcwd() . '../../../');
        chdir($cwd);
        #$this->returnCwd();
        $this->dbModel->generateAdminDB();
        
        if ($cache == true) {
            echo 'Creating cache directory';
            $this->createCacheFolder();
        }
        /*
               $this->utility->generateComposer();
               $this->utility->generateGitIgnore();
               $this->utility->generateEnv();
               $this->utility->generateEnvExample();
		*/
        echo 'Creating view or template' . PHP_EOL;
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
        $templateLayouts .= "\t\t" . '<meta name="robots" content="index, follow">';
        $templateLayouts .= PHP_EOL . "\t</head>" . PHP_EOL . "\t<body>" . PHP_EOL;
        $templateLayouts .= "\t\t" . '<?= $output ?>' . PHP_EOL . "\t</body>" . PHP_EOL . "</html>";

        $view = [$newView => $templateNew, $indexView => $templateIndex, $editView => $templateEdit, $showView => $templateShow];
        chdir($cwd);
        $template_dir = getcwd() . '/app/templates/' . lcfirst($table);
        #echo $_SERVER['DOCUMENT_ROOT'] . "\n\n\n\n\n\n";
        if (!file_exists($template_dir)) {
            mkdir($template_dir, 0777, true);
            if (chdir($template_dir)) {
                foreach ($view as $k => $v) {
                    var_dump(file_put_contents($k, $v));
                }
                /*$layout_dir = getcwd() . '/../layouts';
                if (!file_exists($layout_dir)) {
                    mkdir($layout_dir, 0777, true);
                    if (chdir($layout_dir)) {
                        file_put_contents($layoutsView, $templateLayouts);
                    }
                }*/
                 /*   $stack = debug_backtrace();
$firstFrame = $stack[count($stack) - 1];
#print_r($firstFrame);
$initialFile = $firstFrame['file'];
echo basename(__DIR__) . "now me you we" . PHP_EOL;
$folder = basename(dirname(__FILE__));
var_dump($folder);
#echo realpath($folders[0] ). "ball arsenal". PHP_EOL . PHP_EOL . PHP_EOL;
if (chdir($folder)) {
	echo dirname(__FILE__) . PHP_EOL . PHP_EOL . PHP_EOL;
	echo "cool\n";
}*/
				chdir($cwd);
                $this->template->generateLoginSuccessLayout();
                chdir($cwd);
                $this->template->generateLoginErrorLayout();
                chdir($cwd);
                $this->template->generateLoginLayout();
                chdir($cwd);
                #$this->template->generateLoginLayout();
                $this->template->generateViewMyProfile();
                chdir($cwd);
                $this->template->generateAdminLayout();
                chdir($cwd);
                $this->template->generateRegSuccessLayout();
                chdir($cwd);
                $this->template->generateRegHomeLayout();
                chdir($cwd);
                $this->template->generateViewMyProfile();
                chdir($cwd);
                $this->template->generateLoginRegCss();
            }
            #return true;
        } else {
            if (is_writable($template_dir)) {
                chdir($template_dir);
                file_put_contents($newView, $templateNew);
                file_put_contents($indexView, $templateIndex);
                
            #	return true;
            } else {
                return false;
            }
        }
        chdir($cwd);
        return true;
    }

    public function deScaffold($table)
    {
        echo "Deleting $table....." . "<br/>";
        $t = $table;
        
        $this->dbModel->dropTable($t);
        if ($t) {
            echo "Successfully delete $t";
        }

        echo "Deleting Model class " . ucfirst($table) . "....";
        $this->dbModel->delModel(getcwd() . '/app', ucfirst($table) . '.php');

        echo "Deleting Controller class ucfirst($table)" . "Controller";
        $controller = $controller->delController(getcwd() . '/app/Controllers', ucfirst($table) . 'Controller.php');
        
        echo "Deleting template $table...." . "<br/>";
        $template->dropTemp(getcwd() . '/app/templates/' . $table);
        echo "Successfully delete $table..." . "<br/>";
    }

    private function generateLoginController()
    {
    	$cwd = getcwd();

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
        chdir($cwd);
        $loginController_dir = getcwd() . "/app/Controllers";

        $loginControllerFile = 'LoginController.php';
        if (!file_exists($loginController_dir)) {
            mkdir($loginController_dir, 0777, true);
            if (chdir($loginController_dir)) {
                file_put_contents($loginControllerFile, $controllerScript);
            }
            #return true;
        } else {
            if (is_writable($loginController_dir)) {
                chdir($loginController_dir);
                file_put_contents($loginControllerFile, $controllerScript);
                
            #	return true;
            } else {
                return false;
            }
        }
        
        return true;
    }
    private function generateRegisterController()
    {
    	$cwd = getcwd();
    	
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
        chdir($cwd);
        $regController_dir = getcwd() . "/app/Controllers";
        $regControllerFile = 'RegisterController.php';
        if (!file_exists($regController_dir)) {
            mkdir($regController_dir, 0777, true);
            if (chdir($regController_dir)) {
                file_put_contents($regControllerFile, $controllerScript);
            }
            #return true;
        } else {
            if (is_writable($regController_dir)) {
                chdir($regController_dir);
                file_put_contents($regControllerFile, $controllerScript);
                
            #	return true;
            } else {
                #   return false;
            }
        }
        chdir($cwd);
        return true;
    }

    /*public function generateAdminDB($column = []){
        echo 'Generating the admin model' . "<br/>";
        if(empty($colum)){
            $this->addTableToDB('admin', ['first_name s:(100) nn:', 'last_name string:(100) nn:' , 'email s:(100) nn:', 'password s:(100) nn:', 'username s:(100) nn:']);
            $pw = password_hash('secret', PASSWORD_DEFAULT);
            $query = 'INSERT INTO `admin`(`first_name`, `last_name`, `email`, `password`, `username`) VALUES ("Willy", "Keysers", "stephenogunbule@example.com", :pw, "robbert_bassham")';
            $parameters = ['pw' => $pw];
            $sql = $this->pdo->prepare($query);
            $sql->execute($parameters);
        }else{
            $this->dbModel->addTableToDB('admin', $column);
        }

        echo 'FInished generating the admin model' . PHP_EOL;
    }*/
}
