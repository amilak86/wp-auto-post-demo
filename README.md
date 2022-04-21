# WP Auto Post Demo

This sample projects demonstrates how to use []() library for creating new posts (programatically) without having to log into your wordpress dashboard. 

## Demo Link

[https://wp-auto-post-demo.amilakalansooriya.me](https://wp-auto-post-demo.amilakalansooriya.me)

## How to run locally?

Make sure you have following system requirements satisfied:

- Nginx/Apache server configured with PHP 7.4 or higher
- Composer package manager
- NPM (Latest Version)
- Working installation of Wordpress 5.6 or later with the support for Application Passwords. Follow [this link](https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/) to learn how to obtain an application password. If you can't see the application passwords section at the bottom of your wordpress user profile, you may have to enable it [manually](https://wordpress.stackexchange.com/questions/383244/application-passwords-not-working-on-localhost). 

## Basic Usage

Step 1: Clone the repository to your local machine
```
$ git clone git@github.com:amilak86/wp-auto-post-demo.git
```

Step 2: Change directory to the cloned repository dir
```
$ cd wp-auto-post-demo
```

Step 3: Remove existing 'origin' remote
```
$ git remote rm origin
```

Step 4: Run composer to install php dependencies
```
$ composer install
```

Step 5: Run npm to install node dependencies (gulp)
```
$ npm install
```

Step 6: Rename config.sample.php to config.php

Step 7: Open config.php and update the values of below constants:

APP_URL, WP_REST_POST_ENDPOINT, WP_REST_MEDIA_ENDPOINT, WP_REST_AUTH_APP_USER, WP_REST_AUTH_APP_PASS

Step 8: Compile production assets by running below command
```
$ gulp
```
It will minify and copy all the required files to the dist/ directory. 

Step 9: Setup your local web server (Nginx/Apache) to serve the site from the dist/ directory. 

Step 10: Aceess the app in the browser by visiting APP_URL you've set earlier in the config.php

## License

[MIT](./LICENSE)

## Author

[Amila Kalansooriya](https://www.amilakalansooriya.me)

## References
- [https://developer.wordpress.org/rest-api/reference/](https://developer.wordpress.org/rest-api/reference/)
- [https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/](https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/)
- [https://wordpress.stackexchange.com/questions/383244/application-passwords-not-working-on-localhost](https://wordpress.stackexchange.com/questions/383244/application-passwords-not-working-on-localhost)
