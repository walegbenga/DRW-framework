/**
* This plug-in takes one required and two optional arguments as follows:
*
* • id This can be a string containing the ID of an object, an object, or even an array containing several objects 
* and/or object IDs. If none of the optional arguments are also provided then the function returns the object or 
* objects represented by id. If there are optional arguments then the purpose of the function changes to assign the
* value in value to the property in property of the object (or objects) in id.

* • property This optional string argument can contain the name of a property belonging to the object (or objects) 
* in id that requires modifying

* • value If this optional argument is set it represents the value to be assigned to the property in property of 
* the object (or objects) in id. Both the property and value arguments must have values, otherwise G() will simply 
* return the object (or objects) in id.
*/

function G(id, property, value) {
	if (id instanceof Array){
		var tmp = []
		for (var j = 0 ; j < id.length ; ++j)
		tmp.push(G(id[j], property, value))
		return tmp
	}
	
	if (typeof property != UNDEF && typeof value != UNDEF){
		if (typeof value == 'string') value = "'" + value + "'"
			return eval("G('" + id + "')." + property + " = " + value)
		}
		if (typeof id == 'object') return id
		else{
			try { return document.getElementById(id) 
			}
			catch(e) { alert('PJ - Unknown ID: ' + id) 
		}
	}
}

/**
* The S() plug-in is similar to O() with the exception that instead of referencing an object, that object’s style 
* subobject is accessed. Also, since events are not used by it there is no need to check for them in this function. 
* It accepts the following arguments:
*
* • id This can be a string containing the ID of an object, an object, or even an array containing several objects and/or
*  object IDs. If none of the optional arguments are also provided then the function returns the style subobject of 
* the object (or objects) represented by id. If there are optional arguments, then the purpose of the function
* changes to assign the value in value to the property in property of the style subobject of the object (or objects) in id.
*
* • property This optional string argument can contain the name of a property belonging to the style subobject of the 
* object (or objects) in id that requires modifying.
* 
* • value If this optional argument is set it represents the value to be assigned to the property in property of the style
* subobject of the object (or objects) in id. Both the property and value arguments must have values, otherwise S() will 
* simply return the style subobject of the object (or objects) in id.
*/
function S(id, property, value){
	if (id instanceof Array){
		var tmp = []
		for (var j = 0 ; j < id.length ; ++j)
			tmp.push(S(id[j], property, value))
			return tmp
	}
	S()
	
	if (typeof property != UNDEF && typeof value != UNDEF){
		try { return O(id).style[property] = value }
		catch(e) { alert('PJ - Unknown ID: ' + id) }
	}
	else if (typeof id == 'object') return id.style
	else{
		try { return O(id).style }
		catch(e) { alert('PJ - Unknown ID: ' + id) }
	}
}
/*$("#id",  MOUSE_DOWN);*/
/**
* This plug-in requires no arguments and doesn’t return any. However, please refer to the table of variables, arrays, and 
* functions in the next section, as some very important global variables are set up by it.
*/
function Initialize(){
	MOUSE_DOWN = false
	MOUSE_IN = true
	MOUSE_X = 0
	MOUSE_Y = 0
	SCROLL_X = 0
	SCROLL_Y = 0
	KEY_PRESS = ''
	ZINDEX = 1000
	CHAIN_CALLS = []
	INTERVAL = 30
	UNDEF = 'undefined'
	HID = 'hidden'
	VIS = 'visible'
	ABS = 'absolute'
	FIX = 'fixed'
	REL = 'relative'
	STA = 'static'
	INH = 'inherit'
	TP = 'top'
	BM = 'bottom'
	LT = 'left'
	RT = 'right'

	if (document.all) BROWSER = 'IE'
	else if (window.opera) BROWSER = 'Opera'
	else if (NavCheck('Chrome')) BROWSER = 'Chrome'
	else if (NavCheck('iPod') BROWSER = 'iPod'
	else if (NavCheck('iPhone') BROWSER = 'iPhone'
	else if (NavCheck('iPad')) BROWSER = 'iPad'
	else if (NavCheck('Android')) BROWSER = 'Android'
	else if (NavCheck('Safari')) BROWSER = 'Safari'
	else if (NavCheck('Gecko')) BROWSER = 'Firefox'
	else BROWSER = 'UNKNOWN'
	
	document.onmousemove = CaptureMouse
	document.onkeydown = CaptureKeyboard
	document.onkeypress = CaptureKeyboard
	document.onmouseout = function() { MOUSE_IN = false }
	document.onmouseover = function() { MOUSE_IN = true }
	document.onmouseup = function() { MOUSE_DOWN = false }
	document.onmousedown = function() { MOUSE_DOWN = true }
	
	function NavCheck(check){
		return navigator.userAgent.indexOf(check) != -1
	}
}

/* Page 40 */