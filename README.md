database: ./database/crazybaby.sql

PHP Version: 5.5.12

Nginx Version: 1.10.1

MySQL Version: 5.6.30




Nginx/Apache指向到public/


Nginx Url rewrite:
没有用官方带的改写方式，因为放到了api目录里
##########################
location /api/{
    index index.php;
    if (!-e $request_filename){
        #try_files /api/$uri /api/$uri/ /index.php?$query_string;
        rewrite ^/api/(.*)$ /api/index.php$1 last; 
        break;
    }
}
