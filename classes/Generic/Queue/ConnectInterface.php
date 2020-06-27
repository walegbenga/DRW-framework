<?php

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 26/05/20
* Time : 07:30
*/

interface ConnectInterface
{
	// It will establish a queue connection
	/*
	* Actually, I willingly put it in an interface because, more queue library might be added later
	*/
	public function connect(array $config);
}