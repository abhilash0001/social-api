<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once __ROOT__.'/ga/GoogleAnalyticsHelper.php';
require_once(__ROOT__.'/vendor/gapi/gapi.class.php'); 

class GoogleAnalytics
{

	public static function getInstance() {
		return new GoogleAnalyticsHelper();
	}

    // Get Browser Stats
	public static function getBrowserStats() {
		$cachedData = phpFastCache::get("ga-browser-stats");
		if ($cachedData != null)
			return $cachedData;

		$ga = self::getInstance();
		try{
			return $ga->queryApi(array('dimensions' => 'ga:browser', 
										'metrics' => 'ga:visits', 
										'sort' => '-ga:visits'), function($result){
											$stats = new BrowserVisitStats();
											
											//total visits
											$total = 0;
											foreach ($result->rows as $page) {
										  		$total += $page[1];
										  	}

										  	$stats->totalVisits = $total;

										  	foreach ($result->rows as $page) {
										  		//Get visits per browser
										  		$visits = $page[1] / $total * 100;
										  		//Assign value to corresponding param
										  		switch ($page[0])
										  		{
										  			case 'Firefox':
										  				$stats->firefox = $visits;	
										  				break;
										  			case 'Internet Explorer':
										  				$stats->ie = $visits;	
										  				break;
										  			case 'Safari':
										  				$stats->safari = $visits;	
										  				break;
										  			case 'Chrome':
										  				$stats->chrome = $visits;	
										  				break;
										  		}
										  	}

										  	if ($stats->totalVisits > 0) {
									  			$stats_encoded = json_encode($stats);
									  		}
									  		// Set Cache
											phpFastCache::set("ga-browser-stats", $stats_encoded, CACHE_DURATION);
											return $stats_encoded;
										});
		} catch (Exception $e) {
	 		return ErrorHandler::message('G1', $e->getMessage());
		}
	}

	// Get OS
	public static function getOS() {
		$cachedData = phpFastCache::get("ga-os-stats");
		if ($cachedData != null)
			return $cachedData;

		$ga = self::getInstance();
		try{
			return $ga->queryApi(array('dimensions' => 'ga:operatingSystem', 
										'metrics' => 'ga:visits', 
										'sort' => '-ga:visits'), function($result){
											$stats = new OsStats();
											
											//total visits
											$total = 0;
											foreach ($result->rows as $page) {
										  		$total += $page[1];
										  	}

										  	$stats->totalVisits = $total;

										  	foreach ($result->rows as $page) {
										  		//Get visits per browser
										  		$visits = $page[1] / $total * 100;
										  		//Assign value to corresponding param
										  		switch ($page[0])
										  		{
										  			case 'iOS':
														array_push($stats->mobileOS, array('iOS' => $visits));
														break;
													case 'Android':
														array_push($stats->mobileOS, array('Android' => $visits));	
														break;
													case 'Macintosh':
														array_push($stats->desktopOS, array('Macintosh' => $visits));
														break;
													case 'Windows':
														array_push($stats->desktopOS, array('Windows' => $visits));
														break;
													case 'Linux':
														array_push($stats->desktopOS, array('Linux' => $visits));
														break;
													case 'Chrome OS':
														# code...
														break;
													case 'Firefox OS':
														# code...
														break;
										  		}
										  	}

										  	if ($stats->totalVisits > 0) {
									  			$stats_encoded = json_encode($stats);
									  		}
									  		// Set Cache
											phpFastCache::set("ga-os-stats", $stats_encoded, CACHE_DURATION);
											return $stats_encoded;
										});
		} catch (Exception $e) {
	 		return ErrorHandler::message('G2', $e->getMessage());
		}
	}

	// GET TOP 5 STATES BY VISITORS
	public static function getVisitorsByState(){
		$cachedData = phpFastCache::get("ga-visitor-by-state");
		if ($cachedData != null)
			return $cachedData;

		$ga = self::getInstance();
		try {
			return $ga->queryApi(array('dimensions' => 'ga:region', 
										'metrics' => 'ga:visits', 
										'sort' => '-ga:visits',
										'max-results' => 5,
										'filters' => 'ga:country==United States'), function($result){
											$stats = array();
											foreach ($result->rows as $page) {
												$stats[] = array('state' => $page[0], 'visits' => $page[1]);
											}

											$stats_encoded = json_encode($stats);
									  		// Set Cache
											phpFastCache::set("ga-visitor-by-state", $stats_encoded, CACHE_DURATION);
											return $stats_encoded;
										});
		} catch(Exception $e) {
 			return ErrorHandler::message('G3', $e->getMessage());
		}
	}

	// GET TOP 5 PAGES VIEWED
	public static function getTopPagesViewed(){
		$cachedData = phpFastCache::get("ga-top-pages-viewed");
		if ($cachedData != null)
			return $cachedData;

		$ga = self::getInstance();
		try {
			return $ga->queryApi(array('dimensions' => 'ga:pagePath', 
								      	'metrics' => 'ga:pageviews, ga:uniquePageviews', 
								      	'sort' => '-ga:pageviews',
								      	'max-results' => 10
								    	), function($result){
											$stats = array();
											foreach ($result->rows as $page) {
										  		$stats[] = array( 'url' => $page[0], 'page-views' => (Int)$page[1], 'uniquePageViews' => (Int)$page[2] );
											}

											$stats_encoded = json_encode($stats);
									  		// Set Cache
											phpFastCache::set("ga-top-pages-viewed", $stats_encoded, CACHE_DURATION);
											return $stats_encoded;
										});
		} catch(Exception $e) {
 			return ErrorHandler::message('G4', $e->getMessage());
		}
	}
}

?>