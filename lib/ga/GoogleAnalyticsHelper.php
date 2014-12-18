<?php 

date_default_timezone_set('America/Chicago');

require_once __ROOT__.'/vendor/Google/Client.php';
require_once __ROOT__.'/vendor/Google/Service/Analytics.php';

class GoogleAnalyticsHelper{
	// PRIVATE MEMBERS
	private $client;	
	private $service;
	private $start_date;
	private $end_date;

	public function __construct() {
  		session_start();

  		$this->start_date = date('Y-m-d', strtotime('today - 30 days'));
  		$this->end_date = date('Y-m-d', strtotime('today'));

		$this->client = new Google_Client();
		$this->client->setApplicationName("Tocquigny_Widgets");
		$this->service = new Google_Service_Analytics($this->client);

		//$this->client->revokeToken();
		//$_SESSION['service_token'] = null;

		$this->setToken();
  	}


	/************************************************
	  If we have an access token, we can carry on.
	  Otherwise, we'll get one with the help of an
	  assertion credential. In other examples the list
	  of scopes was managed by the Client, but here
	  we have to list them manually. We also supply
	  the service account
	************************************************/

	private function setToken() {
		if (isset($_SESSION['service_token'])) {
		  $this->client->setAccessToken($_SESSION['service_token']);
		  //return;
		}
		// Get token and set
		$_SESSION['service_token'] = $this->getToken();
	}

	private function getToken() {
		$key = file_get_contents(__ROOT__.'/ga/'.GA_KEY_FILE);
		$cred = new Google_Auth_AssertionCredentials(GA_SERVICE_ACCOUNTNAME, array('https://www.googleapis.com/auth/analytics.readonly'), $key);
		
		$this->client->setAssertionCredentials($cred);
		if($this->client->getAuth()->isAccessTokenExpired()) {
		  $this->client->getAuth()->refreshTokenWithAssertion($cred);
		}
		return $this->client->getAccessToken();
	}


  /**
   * [queryApi description]
   * @param  [type] $optParams [description]
   * @return [type]            [description]
   */
  
	public function queryApi($optParams, $callback = null) {
		$result = $this->service->data_ga->get(urldecode(GA_PROFILE_ID),
												  $this->start_date,
												  $this->end_date,
												  'ga:sessions',
												  $optParams);

		$data = array();
		if(is_null($callback))
		{
			foreach ($result->rows as $value) {
		  	$data[$value[0]] = (Int)$value[1];
		  }
		}else{
			 $data = $callback($result);
		}
		return $data;
	}
}

 ?>