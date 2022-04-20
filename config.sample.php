<?php

// absolute path to the app root
define('APP_ROOT', realpath(__DIR__));

// url where the app is hosted
define('APP_URL', 'http://localhost:3453');

// replace 'wp-rest-api-posts-endpoint' with your url. eg. http://wordpress.local:8080/wp-json/wp/v2/posts
define('WP_REST_POST_ENDPOINT', 'wp-rest-api-posts-endpoint');

// replace 'wp-rest-api-media-endpoint' with your url. eg. http://wordpress.local:8080/wp-json/wp/v2/media
define('WP_REST_MEDIA_ENDPOINT', 'wp-rest-api-media-endpoint');

// replace 'your-wordpress-user-name' with the user name you log into wordpress backend
define('WP_REST_AUTH_APP_USER', 'your-wordpress-user-name');

// replace 'your-wordpress-application-password' with the application password you've generated via the plugin
define('WP_REST_AUTH_APP_PASS', 'your-wordpress-application-password');
