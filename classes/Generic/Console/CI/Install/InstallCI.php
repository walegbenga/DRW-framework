<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 2/05/20
* Time : 07:54
*/

namespace Generic\Console\CI\Install;

use Generic\Console\Traits\SystemConfig;
use Generic\CustomException\CustomException;

class InstallCI{
	// InstallCI means Install Continous Integration
	use SystemConfig;
	
	public function installJenkins(){
		$os_info = $this->getOS();
		$os_name = $this->getOSInformation();

		switch($os_info){
	
			case $os_info === "Windows NT":
			echo "Jenkins downloading about to start...\n";

			try{
				shell_exec("powershell -command \"& { Start-BitsTransfer -Source http://archives.jenkins-ci.org/windows/2.233/jenkins.msi
				.zip -Destination jenkins.zip }\"");
			} catch(CustomException $e){
				echo "Error, probably due to network error\n";
			}
			echo "File fully downloaded...\n";
			echo "Extracting Jenkins...\n";
			$file = "jenkins.zip";
			$zip = new \ZipArchive;
			$res = $zip->open($file);
        
			if($res === true){
				// extract it to the path we determined above
				$zip->extractTo(getcwd());
				$zip->close();
				echo "WOOT! $file extracted to $filepath\n";
				echo "Installation begins now";
				shell_exec("start jenkins.msi");
			} else{
				echo "Doh! I couldn't open $file\n";
			}
		
			break;
	
			case $os_info === "mac OS":
			echo "Jenkins downloading about to start...\n";
			#echo "Installing Jenkins...\n";
			try{
				shell_exec("brew install jenkins-lts@2.234");
			}catch(CustomException $e){
				echo "Error, probably due to network error\n";
			}
			
			echo "Starting Jenkins...\n";
			shell_exec("brew services start jenkins-lts");
			break;

			case $os_info === "Linux":
			echo "Jenkins downloading about to start...\n";
			if($os_name["name"] == "Debian" || $os_name["name"] == "Ubuntu"){
				try{
					shell_exec("wget -q -O - https://pkg.jenkins.io/debian/jenkins.io.key | sudo apt-key add -");
				}catch(CustomException $e){
					echo "Error, probably due to network error\n";
				}
			
				echo "Adding Jenkins...\n";
				try{
					shell_exec("sudo sh -c 'echo deb https://pkg.jenkins.io/debian-stable binary/ > \/etc/apt/sources.list.d/jenkins.list'");
				}catch(CustomException $e){
					echo "Error, probably due to network error\n";
				}
				echo "Updating...\n";
				shell_exec("sudo apt-get update");

				if($repo == "yes"){
					echo "Adding repository universe...\n";
					shell_exec("sudo add-apt-repository universe");
				}
				echo "Installing Jenkins...\n";
				shell_exec("sudo apt-get install jenkins");
			}elseif($os_name["name"] == "fedora" || $os_name["name"] == "Cent OS" || $os_name["name"] == "RedHat"){
				echo "Adding Jenkins repository to the package manager...\n";
				try{	
					shell_exec("sudo wget -O /etc/yum.repos.d/jenkins.repo \http://pkg.jenkins-ci.org/redhat/jenkins.repo");
				}catch(CustomException $e){
					echo "Error, probably due to network error\n";
				}
				try{		
					shell_exec("sudo rpm --import https://jenkins-ci.org/redhat/jenkins-ci.org.key");
				}catch(CustomException $e){
					echo "Error, probably due to network error\n";
				}
				if($os_name["name"] == "fedora"){
					echo "Installing jenkins should begin very soon";
					try{
						shell_exec("sudo dnf upgrade && sudo dnf install jenkins java");
					}catch(CustomException $e){
						echo "Error, probably due to network error\n";
					}

				}else{
					try{
						shell_exec("sudo yum upgrade && sudo yum install jenkins java");
					}catch(CustomException $e){
						echo "Error, probably due to network error\n";
					}
				}

				echo "Starting jenkins...\n";
				shell_exec("sudo service jenkins start");
			}
			break;

			case $os_info === "freeBSD":
			echo "Jenkins downloading about to start...\n";
			try{
				shell_exec("cd /usr/ports/devel/jenkins/ && make install clean");
			}catch(CustomException $e){
				echo "Error, probably due to network error\n";
			}
			
			echo "Installing jenkins will soon start...\n";
			shell_exec("pkg install jenkins");
			echo "Installation finished...\n";
			break;

			case $os_info === "OpenBSD":
			echo "Jenkins downloading about to start...\n";
			#shell_exec("http://mirrors.jenkins-ci.org/war/2.228/jenkins/2.228/jenkins.war");
			try{
				shell_exec("pkg_add jenkins");
			}catch(CustomException $e){
				echo "Error, probably due to network error\n";
			}

			default:
			# code...
			break;
		}
	}
}