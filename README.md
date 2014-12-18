# Social API

This application is built on Slim Framework and is primarly used as an API to interact with various social accounts. Social accounts include Google Analytics, Twitter, Instagram, YouTube and Weather.

Url: [BASE_URL]/v1/

## API Details - V1

## GOOGLE ANALYTICS
Below is the list of api calls available for GA

+ *Get Browser Stats:*
	- Url: [BASE_URL]/v1/ga/getBrowserStats
+ *Get OS Stats:*
    - Url: [BASE_URL]/v1/ga/getOS
+ *Get Top 5 Visitors By State:*
    - Url: [BASE_URL]/v1/ga/getOS
+ *Get Top 10 Pages Viewed:*
	- Url: [BASE_URL]/v1/ga/getTopPagesViewed


## TWITTER
Below is the list of api calls available for Twitter

+ *Get Latest Tweet:*
	- Url: [BASE_URL]/v1/twitter/getLatestTweet
+ *Get Tweets: (Max Count = 10)*
    - Url: [BASE_URL]/v1/twitter/getTweets/{COUNT}


## INSTAGRAM
Below is the list of api calls available for Instagram

+ *Get Latest Post:*
	- Url: [BASE_URL]/v1/instagram/getLatestPost
+ *Get Posts: (Max Count = 10)*
    - Url: [BASE_URL]/v1/instagram/getPosts/{COUNT}


## WEATHER (OPEN WEATHER MAP)
Below is the list of api calls available for Weather

+ *Get Temperature:*
	- Url: [BASE_URL]/v1/weather/getTemperature


## YOUTUBE (GDATA)
Below is the list of api calls available for YouTube

+ *Get Featured Video: (Featured Video Id Required)*
	- Url: [BASE_URL]/v1/youtube/getFeaturedVideo



## CACHING
Since the data does not change very frequently, all the API calls data is stored in-memory using PhpHastCache.

Library Url: http://www.phpfastcache.com/