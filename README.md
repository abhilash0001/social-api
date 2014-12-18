# Social API

This application is built on Slim Framework and is primarly used as an API to interact with various social accounts. Social accounts include Google Analytics, Twitter, Instagram, YouTube and Weather.

This api layer is mainly focused on talking to various social api's. This api layer does not have authorization/authentication. However, there is an authorization built into the SLIM framework which can be utilized to achieve this.

Url: [BASE_URL]/v1/


## SLIM FRAMEWORK
Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.

Url: http://slimframework.com/

It is a standalone framework and all it requires is PHP 5.3.0 or higher. If you are going to use encrypted cookies, make sure mcrypt is installed on the server.

If your the url is not working Ex: [BASE_URL]/v1/ga/getBrowserStats gives you 404 Page Not Found then try this [BASE_URL]/index.php/v1/ga/getBrowserStats. If this url works make sure your .htaccess and vhosts matches the following.

```php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ /index.php [QSA,L]
```


```php
<VirtualHost *:80>
    ServerAdmin me@mysite.com
    DocumentRoot "/path/www.mysite.com/public_html"
    ServerName mysite.com
    ServerAlias www.mysite.com

    #ErrorLog "logs/mysite.com-error.log"
    #CustomLog "logs/mysite.com-access.log" combined

    <Directory "/path/www.mysite.com/public_html">
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

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