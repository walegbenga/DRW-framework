<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 05/04/20
* Time : 22:33
*/

namespace Generic\Console\Util;

class Utility
{
	public function generateComposer(){
		echo 'Generating composer....' . PHP_EOL;
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
		list($scriptPath) = get_included_files();
		echo "$scriptPath\n\n\n\n\n\n\n";
		chdir($scriptPath . "../");
		$composer_dir = __DIR__ . '/';
		$composerFile = 'composer2.json';
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
		echo 'Finish generating composer...' . PHP_EOL;
		echo 'Leaving composer' . PHP_EOL;
		return true;
	}

	public function generateGitIgnore(){
		echo 'Generating .gitignore....' . PHP_EOL;
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
		echo 'Finish generating .gitignore...' . PHP_EOL;
		echo 'Leaving .gitignore' . PHP_EOL;
		return true;
	}

	public function generateEnv(){
		echo 'Generating environment....' . PHP_EOL;

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
		echo 'Finish generating environment...' . PHP_EOL;
		echo 'Leaving environment' . PHP_EOL;
		return true;
	}

	public function generateEnvExample(){
		echo 'Generating environment example....' . PHP_EOL;
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
		echo 'Finish generating environment example...' . PHP_EOL;
		echo 'Leaving environment example' . PHP_EOL;
		return true;
	}
}