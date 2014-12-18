<?php

class CurlHelper{
	
	private function __construct()
    {

    }

    /*
		HOW TO USE
		$response = CurlHelper::makeGetRequest($url);
	*/
	public static function makeGetRequest($url){
		$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
    			CURLOPT_URL => $url
			));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	/*
		HOW TO USE
		$params = array('id' => $id,
				        'username' => $username,
				        'password' => $password);

		$response = CurlHelper::makePostRequest($url, json_encode($params));
	*/
	public static function makePostRequest($url, $params){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url,
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => $params
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
}

?>