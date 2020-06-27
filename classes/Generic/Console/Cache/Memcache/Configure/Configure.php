<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 11/04/20
* Time : 15:46
*/

namespace Generic\Cache\Configure;

class Configure
{
	public function configureVirnish()
	{
		// Configuring default.vcl
		echo "Configuring default.vcl...";
		echo "You can always edit the default.vcl at default.vcl....";
		shell_exec("cp path/to/default.vcl-which-i-downloaded-from-github-v-6 /etc/varnish/default.vcl");
	}

	/**
	*	Memcached Configuration
	*
	*/
	public function configureMemcached()
	{

	}

	public function startMemcached()
	{
		echo "Memcached about to start...\n";
		shell_exec("telnet 127.0.0.1 11211");
		echo "Memcached Started\n";
	}

	/**
	*	Redis configurations
	*
	*/
	public function configureRedis()
	{

	}

	public function startRedis()
	{
		switch ($os) {
			case $os === "macos":
				shell_exec("brew services start redis");
				break;

			case $os === "windows" || $os === "linux":
				shell_exec("sudo service redis-server start");
				break;
			
			default:
				# code...
				break;
		}
	}

	public function stopRedis()
	{
		switch ($os) {
			case $os === "macos":
				shell_exec("brew services stop redis");
				break;

			case $os === "windows" || $os === "linux":
				shell_exec("sudo service redis-server stop");
				break;
			
			default:
				# code...
				break;
		}
	}

	public function restartRedis()
	{
		switch ($os) {
			case $os === "macos":
				shell_exec("brew services restart redis");
				break;

			case $os === "windows" || $os === "linux":
				shell_exec("sudo service redis-server restart");
				break;
			
			default:
				# code...
				break;
		}
	}

	public function pingRedis()
	{
		echo "Starting ping...\n";
		shell_exec("redis-cli ping");
	}
}