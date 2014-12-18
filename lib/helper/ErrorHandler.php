<?php

/**
*  Error Handler Class to enhance
*/
class ErrorHandler
{
	
	function __construct()
	{	
	}

	public static function message($code, $message) {
		return json_encode(array('error' => array('code' => $code, 'message' => $message)));
	}
}

?>