<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 05/04/20
* Time : 22:23
*/

namespace Generic\Console\Templates;

class TemplateGenerator
{
	public function generateLoginLayout(){
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

		$login_dir = getcwd() . '/app/templates/login';
		if(file_exists($login_dir)){
			#mkdir($login_dir, 0777, true);
			if(chdir($login_dir)){
				file_put_contents($loginView, $loginLayouts);
			}
		}
		echo 'Finish generating the admin login files and folder' . "<br/>";
	}

	public function generateLoginRegCss(){
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

		$css_dir = getcwd() . '/app/assets/css';
		#$css_dir = getcwd() . 'f(!file_exists($css_dir)){
			mkdir($css_dir, 0777, true);
			if(chdir($css_dir)){
				file_put_contents($cssView, $cssLayouts);
			}
		#}
		echo 'Finish generating the admin login css and folder' . "<br/>";
	}

	public function generateAdminLayout(){
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

		$reg_dir = getcwd() . '/app/templates/admin';
		if(file_exists($reg_dir)){
			#mkdir($reg_dir, 0777, true);
			if(chdir($reg_dir)){
				file_put_contents($regView, $regLayouts);
			}
		}
		echo 'Finish generating the admin registration files and folder' . "<br/>";
	}
	
	public function generateLoginErrorLayout(){
		echo 'Generating Admin Login error page and folder' . "<br/>";
		$loginErrorView = 'loginerror.html.php';

		$loginErrorLayouts = '<h2>You are not logged in</h2>' . PHP_EOL;
		$loginErrorLayouts .= '<p>You must looged in to view this page. <a href="/login/new">Click here to login</a> or <a href="/register/new">Click to register an account</a></p>';

		$loginerror_dir = getcwd() . '/app/templates/login';
		if(file_exists($loginerror_dir)){
			#mkdir($loginerror_dir, 0777, true);
			if(chdir($loginerror_dir)){
				file_put_contents($loginErrorView, $loginErrorLayouts);
			}
		}
		echo 'Finish generating the admin login error files and folder' . "<br/>";
	}

	public function generateLoginSuccessLayout(){
		echo 'Generating Admin Login success page and folder' . "<br/>";
		$loginSuccessView = 'loginsuccess.html.php';

		$loginSuccessLayouts = '<h2>You are now logged in</h2>' . PHP_EOL;
		$loginSuccessLayouts .= '<p>If you are not redirected in 10 secons, please <a href="/">Click here to login</a> </p>';

		$loginsuccess_dir = getcwd() . '/app/templates/login';
		if(!file_exists($loginsuccess_dir)){
			mkdir($loginsuccess_dir, 0777, true);
			if(chdir($loginsuccess_dir)){
				file_put_contents($loginSuccessView, $loginSuccessLayouts);
			}
		}
		echo 'Finish generating the admin login success files and folder' . "<br/>";
	}
	
	public function generateRegSuccessLayout(){
		echo 'Generating Admin register success page and folder' . "<br/>";
		$regSuccessView = 'registersuccess.html.php';

		$regSuccessLayouts = '<h2>Registration successful</h2>' . PHP_EOL;
		$regSuccessLayouts .= '<p>If you are not redirected in 10 secons, please <a href="/login">Click here to login</a> </p>';

		$regsuccess_dir = getcwd() . '/app/templates/admin';
		if(file_exists($regsuccess_dir)){
			#mkdir($regsuccess_dir, 0777, true);
			if(chdir($regsuccess_dir)){
				file_put_contents($regSuccessView, $regSuccessLayouts);
			}
		}
		echo 'Finish generating the admin register success files and folder' . "<br/>";
	}

	public function generateRegHomeLayout(){
		echo 'Generating Admin index success page and folder' . "<br/>";
		$regView = 'home.html.php';

		$regLayouts = '<h2>Welcome to our home page</h2>' . PHP_EOL;
		#$regLayouts .= '<p>If you are not redirected in 10 secons, please <a href="/login">Click here to login</a> </p>';

		$reg_dir = getcwd() . '/app/templates/admin';
		if(file_exists($reg_dir)){
			#mkdir($regsuccess_dir, 0777, true);
			if(chdir($reg_dir)){
				file_put_contents($regView, $regLayouts);
			}
		}
		echo 'Finish generating the admin register index files and folder' . "<br/>";
	}

	public function generateViewMyProfile(){
		echo 'Generating Admin view profile page and folder' . "<br/>";
		$viewMyProfileView = 'viewmyprofile.html.php';

		$viewProfileLayouts = '<h2><?=$title?>("<?=adminProfile->firstName $adminProfile->lastName?>")</h2>' . PHP_EOL;
		$viewProfileLayouts .= '<ul>' . PHP_EOL;
		$viewProfileLayouts .= "\t<li>" . '<?=adminProfile->firstName $adminProfile->lastName?>' . "</li>" . PHP_EOL;
		$viewProfileLayouts .= "\t<li>" . '<?=adminProfile->username?>' . "</li>" . PHP_EOL;
		$viewProfileLayouts .= "\t<li>" . '<?=adminProfile->email?>' . "</li>" . PHP_EOL;
		$viewProfileLayouts .= "</ul>" . PHP_EOL;

		$viewprofile_dir = getcwd() . '/app/templates/admin';
		if(!file_exists($viewprofile_dir)){
			mkdir($viewprofile_dir, 0777, true);
			if(chdir($viewprofile_dir)){
				file_put_contents($viewMyProfileView, $viewProfileLayouts);
			}
		}
		echo 'Finish generating the admin view my profile files and folder' . "<br/>";	
	}
	
	public function generateForegetPasswordLayout(){
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

		$fp_dir = getcwd() . '/app/templates/forgetpassword';
		if(!file_exists($fp_dir)){
			mkdir($fp_dir, 0777, true);
			if(chdir($fp_dir)){
				file_put_contents($fpView, $fpLayouts);
			}
		}
		echo 'Finish generating the admin login files and folder' . "<br/>";
	}
	
	public function generateResetPasswordLayout(){
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

		$fp_dir = getcwd() . '/app/templates/resetpassword';
		if(!file_exists($fp_dir)){
			mkdir($fp_dir, 0777, true);
			if(chdir($fp_dir)){
				file_put_contents($fpView, $fpLayouts);
			}
		}
		echo 'Finish generating the admin login files and folder' . "<br/>";
	}

	public function delModel( $file){
		$file = $file . "html.php";
		echo "Deleting $file...\n";
		if(is_dir(getcwd() . "/app/templates"))
			if(chdir(getcwd() . "/app/templates"))
				unlink( $file);
			else
				echo "Unable to access the directory\n";
		else
			echo "The directory does not exist\n";
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
}