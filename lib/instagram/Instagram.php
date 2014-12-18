<?php

class Instagram {

	public static function getLatestPost(){
		$posts = self::get();
		if (isset($posts)) {
			return json_encode($posts[0]);
		}
		return ErrorHandler::message('I1', 'Unable to get posts.');
	}

	public static function getPosts($count){
		if ($count > INSTA_LIMIT)
			return ErrorHandler::message('I2', 'Post count ('.$count.') is more than API Instagram Limit');

		$posts = self::get();
		if (isset($posts)) {
			return json_encode(array_slice($posts, 0, $count));
		}

		return ErrorHandler::message('T1', 'Unable to get posts.');
	}

	private static function get(){
		$cachedData = phpFastCache::get("instagram-post");
		if ($cachedData != null)
			return json_decode($cachedData);

		$url = 'https://api.instagram.com/v1/users/'.INSTA_USERID.'/media/recent/?client_id='.INSTA_CLIENTID.'&count='.INSTA_LIMIT;
		try {
			$data = CurlHelper::makeGetRequest($url);
			$decodedData = json_decode($data);
			if ($decodedData->meta->code == 200){
				$posts = array();

				foreach ($decodedData->data as $data) {
					$p = new Post();
					$p->caption = $data->caption->text;
					$p->link = $data->link;
					$p->likes = $data->likes->count;
					$p->comments = $data->comments->count;
					$p->thumbnail = $data->images->thumbnail->url;
					$p->standard_resolution = $data->images->standard_resolution->url;
					$p->low_resolution = $data->images->low_resolution->url;

					$posts[] = $p;
				}

				phpFastCache::set("instagram-post", json_encode($posts), CACHE_DURATION);
				return $posts;
			}
			return ErrorHandler::message('T3', $data);
		} catch(Exception $e) {
			return ErrorHandler::message('I3', $e->getMessage());
		}

	}

}

class Post {
	public $caption = "";
	public $link = "";
	public $likes = "";
	public $comments = "";
	public $thumbnail = "";
	public $standard_resolution = "";
	public $low_resolution = "";
}

?>