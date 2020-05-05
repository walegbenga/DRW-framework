<?php
/**
* Document your script
*/
# Your controller API name
namespace Api\Controllers\controllerAPI
class afdControllerAPI{
# Display form
	public function new() {
		return json_encode(value);
	}
	# Process form
	public function create() {
		return json_decode(file_get_contents('php://input'), TRUE);
	}
	# Update/ process an existing form
	public function update() {
		return json_decode(file_get_contents('php://input'), TRUE);
	}
	# The home page/ default page
	public function index() {
		return json_encode(value);
	}
	# Delete a record
	public function delete() {
	}
}
