<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 18/12/18
* Time : 22:25
*/

namespace Generic\EntryPoint;

class EntryPoint{
    private $route;
	private $method;
	private $routes;

	public function __construct(string $route, string $method, \Generic\Route $routes) {
		$this->route = $route;
		$this->routes = $routes;
		$this->method = $method;
		$this->checkUrl();
		#$this->cleanUrlText();
	}

	private function checkUrl() {
		if ($this->route !== strtolower($this->route)) {
			http_response_code(301);
			header('location: ' . strtolower($this->route));
		}
	}

	// Added on the day function search() was added in Database class
	private function cleanUrlText(){
		// Remove all characters that aren't a-z, 0-9, dash, underscore or space
		$not_acceptable_characters_regex = '#[^-a-zA-Z0-9_ /]#';
		$this->route = preg_replace($not_acceptable_characters_regex, '', $this->route);

		// Remove all leading and trailing spaces
		$this->route = trim($this->route);

		// Change all dashes, underscores and spaces to dashes
		$this->route = preg_replace('#[-_ ]+#', '-', $this->route);

		// Return the modified string
		return strtolower($this->route);
	}

	private function loadTemplate($templateFileName, $variables = []) {
		extract($variables);

		ob_start();
		require  __DIR__ . '/../../../app/templates/' . $templateFileName;

		return ob_get_clean();
	}

	public function run() {

		$routes = $this->routes->getRoutes();	

		$authentication = $this->routes->getAuthentication();

		if (isset($routes[$this->route]['login']) && !$authentication->isLoggedIn()) {
			header('location: /login/error');
		}
		else if (isset($routes[$this->route]['permissions']) && !$this->routes->checkPermission($routes[$this->route]['permissions'])) {
			header('location: /login/permissionserror');	
		}
		else {
			$controller = $routes[$this->route][$this->method]['controller'];
			$action = $routes[$this->route][$this->method]['action'];
			$page = $controller->$action();

			$title = $page['title'];

			if (isset($page['variables'])) {
				$output = $this->loadTemplate($page['template'], $page['variables']);
				//var_dump($page['variables']);
			}
			else {
				$output = $this->loadTemplate($page['template']);
			}

			echo $this->loadTemplate('layouts/application.html.php', ['loggedIn' => $authentication->isLoggedIn(),
			                                             'output' => $output,
			                                             'title' => $title
			                                            ]);

		}

	}
}