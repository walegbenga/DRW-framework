<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 18/07/19
* Time : 23:21
*/

namespace Generic;

class DocCommenter{
	/**
	* This class is use to document your class for other programmers to use and to know how to interact with your class
	*/
	private $name;
	private $publicMethods = [];
	private $protectedMethods = [];
	private $privateMethods = [];
	private $publicProperties = [];
	private $protectedProperties = [];
	private $privateProperties = [];

	/**
	* The createDataMemberArrays method and the companion method for creating an array of methods are both private and 
	* called from within the constructor of the Documenter class.
	*/
	public function __construct($name){
		parent::__construct($name);
		$this->createDataMemberArrays();
		$this->getAllMethods();
	}

	/**
	* This code calls a number of self-explanatory, inherited methods to build a class description. The only slight 
	* complication is that, because a class can implement more than one interface, the getInterfaces method returns an 
	* array, and so requires a foreach loop. When applied to the SoapFault class, the following string is returned by the 
	* getFullDescription method:
	*/
	public function getClassFullDescription(\ReflectionClass $class){
		$description = "";
		if($class->isFinal()){
			$description = "final ";
		}

		if($class->isAbstract()){
			$description = "abstract ";
		}

		if($class->isInterface()){
			$description .= "interface ";
		}else{
			$description .= "class ";
		}

		$description .= $this->name . " ";
		if($class->getParentClass()){
			$name = $class->getParentClass()->getName();
			$description .= "extends $name ";
			$interfaces = $class->getInterfaces();
			$number = count($interfaces);
			
			if($number > 0){
				$counter = 0;
				$description .= "implements ";
			
				foreach($interfaces as $i){
					$description .= $i->getName();
					$counter ++;
					
					if($counter != $number){
						$description .= ", ";
					}
				}
			}
			return $description;
		}
	}

	/**
	* An array of all methods of a class is retrieved using the inherited ReflectionClass method getMethods, and each 
	* ReflectionMethod object is stored in the appropriate associative array, using the method name as the array key
	* Placement of the call to the parent constructor is noteworthy. Because createDataMemberArrays and getAllMethods 
	* both invoke methods of the parent class, it is essential that the call to the parent constructor occur first. Doing 
	* otherwise results in calling methods on a not-yet-existent object.
	*/
	private function getAllMethods(\ReflectionClass $class){
		$methods = $this->getMethods();
		//Reflection Method array returned
		
		foreach($methods as $m){
			$name = $m->getName();
			if($m->isPublic()){
				$this->publicmethods[$name] = $m;
			}
			
			if($m->isProtected()){
				$this->protectedmethods[$name] = $m;
			}
			
			if($m->isPrivate()){
				$this->privatemethods[$name] = $m;
			}
		}
	}

	public function getMethod(\ReflectionMethod $method){
		$details = "";
		$name = $method->getName();

		if ($method->isUserDefined()) {
			$details .= "$name is user defined\n";
		}

		if ($method->isInternal()) {
			$details .= "$name is built-in\n";
		}

		if ($method->isAbstract()) {
			$details .= "$name is abstract\n";
		}

		if ($method->isPublic()) {
			$details .= "$name is public\n";
		}

		if ($method->isProtected()) {
			$details .= "$name is protected\n";
		}

		if ($method->isPrivate()) {
			$details .= "$name is private\n";
		}
		
		if ($method->isStatic()) {
			$details .= "$name is static\n";
		}

		if ($method->isFinal()) {
			$details .= "$name is final\n";
		}
		
		if ($method->isConstructor()) {
			$details .= "$name is the constructor\n";
		}

		if ($method->returnsReference()) {
			$details .= "$name returns a reference (as opposed to a value)\n";
		}
		return $details;
	}

	/**
	* See the method for details
	*/
	private function createDataMemberArrays(){
		$properties = $this->getProperties();
		//Reflection Method array returned
		
		foreach($properties as $p){
			$name = $p->getName();
			if($p->isPublic()){
				$this->publicProperties[$name] = $m;
			}
			
			if($p->isProtected()){
				$this->protectedProperties[$name] = $m;
			}
			
			if($p->isPrivate()){
				$this->privateProperties[$name] = $m;
			}
		}
	}
	/**
	* It is essential to know the access modifiers for methods and data members of a class. Both the ReflectionMethod and 
	* the ReflectionParameter classes have a getModifiers method that returns an integer with bit fields set to flag the 
	*different access modifiers.
	*/
	public function getModifiers($r){
		if($r instanceof ReflectionMethod || $r instanceof ReflectionProperty){
			$arr = Reflection::getModifierNames($r->getModifiers());
			$description = implode(" ", $arr );
		}else{
			$msg = "Must be ReflectionMethod or ReflectionProperty";
			throw new ReflectionException( $msg );
		}
		return $description;
	}

	public function getMethodSource(\ReflectionMethod $method):string{
		$path = $method->getFileName();
		$lines = @file($path);
		$from = $method->getStartLine();
		$to = $method->getEndLine();
		$len = $to - $from + 1;
		return implode(array_slice($lines, $from - 1, $len));
	}

	
}