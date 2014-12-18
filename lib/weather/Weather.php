<?php

/*	
* 	WEATHER - OPEN WEATHER MAP
*/

class Weather
{
	public static function getTemperature(){
		$cachedData = phpFastCache::get("weather");
		if ($cachedData != null)
			return $cachedData;

		$url = 'http://api.openweathermap.org/data/2.5/weather?q=Austin,TX';

		try {
			$data = CurlHelper::makeGetRequest($url);
			$decodedData = json_decode($data);
			if ($decodedData->cod == 200){
				$w = new WeatherInfo();
				$w->city = $decodedData->name;
				$w->latlong = $decodedData->coord->lat.','.$decodedData->coord->lon;
				$w->weatherType = $decodedData->weather[0]->main;
				$w->weatherDescription = $decodedData->weather[0]->description;
				$w->currentTemp = self::ConvertToFahrenheit($decodedData->main->temp);
				$w->tempMin = self::ConvertToFahrenheit($decodedData->main->temp_min);
				$w->tempMax = self::ConvertToFahrenheit($decodedData->main->temp_max);

				$encoded_data = json_encode($w);
				phpFastCache::set("weather", $encoded_data, CACHE_DURATION);
				return $encoded_data;
			}
			return ErrorHandler::message('W1', $data);
		} catch(Exception $e) {
			return ErrorHandler::message('W2', $e->getMessage());
		}
	}

	private static function ConvertToFahrenheit($tempInKelvins){
		return (($tempInKelvins - 273.15)*1.8)+32;
	}
}

class WeatherInfo {
	public $city = "";
	public $latlong = "";
	public $weatherType = "";
	public $weatherDescription = "";
	public $currentTemp = "";
	public $tempMin = "";
	public $tempMax = "";
}

?>