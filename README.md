Yii 2 Platform Application Template
===================================


DIRECTORY STRUCTURE
-------------------

```
common
	config/             contains shared configurations
	models/             contains model classes used in both backend and frontend
console
	config/             contains console configurations
	controllers/        contains console controllers (commands)
	migrations/         contains database migrations
	models/             contains console-specific model classes
	runtime/            contains files generated during runtime
backend
	assets/             contains application assets such as JavaScript and CSS
	config/             contains backend configurations
	controllers/        contains Web controller classes
	models/             contains backend-specific model classes
	runtime/            contains files generated during runtime
	views/              contains view files for the Web application
	web/                contains the entry script and Web resources
frontend
	assets/             contains application assets such as JavaScript and CSS
	config/             contains frontend configurations
	controllers/        contains Web controller classes
	models/             contains frontend-specific model classes
	runtime/            contains files generated during runtime
	views/              contains view files for the Web application
	web/                contains the entry script and Web resources
rest
	config/             contains REST API configurations
	controllers/        contains REST API controller classes
	runtime/            contains files generated during runtime
vendor/                 contains dependent 3rd-party packages
environments/                contains environment-based overrides
```


REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install the application using the following command:

~~~
php composer.phar create-project --stability=dev filsh/yii2-app-platform app-platform
~~~


GETTING STARTED
---------------

After you install the application, you have to conduct the following steps to initialize
the installed application. You only need to do these once for all.

1. Run command `init` to initialize the application with a specific environment.
2. Create a new database and adjust the `components.db` configuration in `common/config/params.php` accordingly.
3. Run command `yii migrate` to apply DB migrations.

Now you should be able to access:

- the frontend using the URL `http://localhost/advanced/frontend/web/`
- the backend using the URL `http://localhost/advanced/backend/web/`
- the REST API using the URL `http://localhost/advanced/rest/v1.0/`

NGINX CONFIGURATION
-------------------------------

~~~
server {
	set $path_host "/var/www/yii2-app-platform/frontend/web";
	set $path_index "index.php";

	server_name www.platform.dev;
	root $path_host;
	index $path_index;

	listen   80;
	charset utf-8;
	client_max_body_size 128M;

	error_page 500 502 503 504 /50x.html;

	location = /50x.html {
		root /usr/share/nginx/www;
	}

	location / {
		try_files $uri $uri/ /$path_index?$query_string;
	}

	location ~ \.php$ {
		fastcgi_split_path_info ^(.+\.php)(/.+)$;
		fastcgi_index $path_index;
		fastcgi_pass php-fpm;
		
		fastcgi_connect_timeout 30s;
		fastcgi_read_timeout 30s;
		fastcgi_send_timeout 60s;
		fastcgi_ignore_client_abort on;
		fastcgi_pass_header "X-Accel-Expires";

		fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
		fastcgi_param  PATH_INFO        $fastcgi_path_info;
		fastcgi_param  HTTP_REFERER     $http_referer;
		include fastcgi_params;
	}

	location ~* \.(js|css|less|png|jpg|jpeg|gif|ico|woff|ttf|svg|tpl)$ {
		expires 24h;
		access_log off;
	}

	location = /favicon.ico {
		log_not_found off;
		access_log off;
	}

	location = /robots.txt {
		log_not_found off;
		access_log off;
	}

	location ~ /\. {
		deny all;
		access_log off;
		log_not_found off;
	}
}
~~~

When using this configuration, you should set `cgi.fix_pathinfo=0` in the `php.ini` file in order to avoid many unnecessary system `stat()` calls.
