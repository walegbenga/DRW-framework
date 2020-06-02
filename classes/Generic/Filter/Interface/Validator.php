<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 18/05/2020
* Time: 09:15
*/

namespace Generic\Filter;

class Validator extends AbstractFilter{
	// code
	public function process(array $data){
		$valid = TRUE;
		if(!(isset($this->assignments)
				&& count($this->assignments))){
			return $valid;
		}
		foreach($data as $key => $value){
			$this->results[$key] = new Result(TRUE, array());
		}
		foreach($data as $key => $value){
			$this->results[$key] = new Result(TRUE, array());
		}

		$toDo = $this->assignments;
		if(isset($toDo['*'])){
			$this->processGlobalAssignment($toDo['*'], $data);
			unset($toDo['*']);
		}

		foreach($toDo as $key => $assignment){
			if(!isset($data[$key])){
				$this->results[$key] =
				new Result(FALSE, $this->missingMessage);
			} else{
				$this->processAssignment(
					$assignment, $key, $data[$key]);
			}
			if(!$this->results[$key]->item) $valid = FALSE;
		}
		return $valid;
	}

	protected function processGlobalAssignment($assignment, $data){
		foreach($assignment as $callback){
			if($callback === NULL) continue;
			foreach($data as $k => $value){
				$result = $this->callbacks[$callback['key']]
				($value, $callback['params']);
				$this->results[$k]->mergeValidationResults($result);
			}
		}
	}

	protected function processAssignment($assignment, $key, $value){
		foreach($assignment as $callback){
			if($callback === NULL) continue;
			$result = $this->callbacks[$callback['key']]
			($value, $callback['params']);
			$this->results[$key]->mergeValidationResults($result);
		}
	}
}