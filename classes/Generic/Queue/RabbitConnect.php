<?php

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 26/05/20
* Time : 07:39
*/

class RabbitConnect implements ConnectInterface
{
	// Rabbit connect instance
	protected $rabbit;

	// Connection name
	protected $connection;

	// Create a rabbit queue connction instance
	public function __construct(Rabbit $rabbit, $connction = null)
	{
		$this->rabbit = $rabbit;
		$this->connection = $connection;
	} 

	/** Get the queue connection and return the 
	* @param array config
	*/
	public function connect(array $config)
	{
		return new RabbitQueue(
			$this->rabbit, $config['queue'],
			$config['connection'] ?? $this->connection,
			$config['retry_after'] ?? 60,
            $config['block_for'] ?? null
		);
	}
}