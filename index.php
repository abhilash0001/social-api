<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

date_default_timezone_set('America/Chicago');

/* API INCLUDES */
require 'lib/config.php';
require 'lib/ga/GoogleAnalytics.php';
require 'lib/ga/GaEntity.php'; 
require 'lib/instagram/Instagram.php';
require 'lib/twitter/Twitter.php';
require 'lib/weather/Weather.php';
require 'lib/youtube/YouTube.php';
require 'lib/php_fast_cache.php';
require 'lib/helper/CurlHelper.php';
require 'lib/helper/ErrorHandler.php';

/* CACHING */
phpFastCache::$storage = "auto";

/*
	API VERSION 1 (V1)
*/ 
$app->group('/v1', function () use ($app){

	// GOOGLE ANALTICS
	$app->group('/ga', function () use ($app){

		// GET BROWSER STATS
		$app->get('/getBrowserStats', function() use ($app){
			echo GoogleAnalytics::getBrowserStats();
		});

		// GET STATS BY OPERATING SYSTEM
		$app->get('/getOS', function() use ($app){
			echo GoogleAnalytics::getOS();
		});

		// GET STATS BY OPERATING SYSTEM
		$app->get('/getVisitorsByState', function() use ($app){
			echo GoogleAnalytics::getVisitorsByState();
		});

		// GET TOP PAGES VIEWED
		$app->get('/getTopPagesViewed', function() use ($app){
			echo GoogleAnalytics::getTopPagesViewed();
		});
	});

	// TWITTER
	$app->group('/twitter', function () use ($app){

		// GET LATEST TWEET
		$app->get('/getLatestTweet', function() use ($app){
			echo Twitter::getLatestTweet();
		});

		// GET TWEETS
		$app->get('/getTweets/:count', function($count) use ($app){
			echo Twitter::getTweets($count);
		});

	});

	// INSTAGRAM
	$app->group('/instagram', function () use ($app){

		// GET LATEST POST
		$app->get('/getLatestPost', function() use ($app){
			echo Instagram::getLatestPost();
		});

		// GET POSTS
		$app->get('/getPosts/:count', function($count) use ($app){
			if (!isset($count) && $count <= 0)
				$count = 1;

			echo Instagram::getPosts($count);
		});

	});

	// WEATHER
	$app->group('/weather', function () use ($app){

		// GET TEMPERATURE
		$app->get('/getTemperature', function() use ($app){
			echo Weather::getTemperature();
		});

	});

	// YOUTUBE
	$app->group('/youtube', function () use ($app){

		// GET TEMPERATURE
		$app->get('/getFeaturedVideo', function() use ($app){
			echo YouTube::getFeaturedVideo();
		});

	});

	// ALL IN ONE. AS PER BEN'S REQUEST
	$app->get('/all', function() use ($app){
		// GA
		echo GoogleAnalytics::getBrowserStats();
		echo GoogleAnalytics::GetOS();
		echo GoogleAnalytics::getVisitorsByState();

		// TWITTER
		echo Twitter::getLatestTweet();
		
		// INSTAGRAM
		echo Instagram::getPosts(1);
	});
});

$app->run();
