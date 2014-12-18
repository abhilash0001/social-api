<?php

/*
*  YOUTUBE
*/
class YouTube
{
	public static function getFeaturedVideo() {
		$cachedData = phpFastCache::get("youtube");
		if ($cachedData != null)
			return $cachedData;

		$url = 'http://gdata.youtube.com/feeds/api/users/tocquigny/uploads/'.YOUTUBE_FEATURED.'?prettyprint=true&alt=json';
		try {
			$data = CurlHelper::makeGetRequest($url);
			$decodedData = json_decode($data);
			
			if (isset($decodedData->entry)){
				$y = new YouTubeInfo();

				$y->title = $decodedData->entry->title->{'$t'};
				$y->description = $decodedData->entry->content->{'$t'};
				$y->favoriteCount = $decodedData->entry->{'yt$statistics'}->favoriteCount;
				$y->viewCount = $decodedData->entry->{'yt$statistics'}->viewCount;
				$y->thumbnails = json_encode($decodedData->entry->{'media$group'}->{'media$thumbnail'});
				$y->url = YOUTUBE_BASE_URL.YOUTUBE_FEATURED;

				$encoded_data = json_encode($y);
				phpFastCache::set("youtube", $encoded_data, CACHE_DURATION);
				return $encoded_data;
			}
			return ErrorHandler::message('Y1', $data);

			var_dump($decodedData);
		} catch(Exception $e) {
			return ErrorHandler::message('Y2', $e->getMessage());
		}
	}
}

class YouTubeInfo
{
	public $title = "";
	public $description = "";
	public $favoriteCount = "";
	public $viewCount = "";
	public $thumbnails = "";
	public $url = "";
}

?>