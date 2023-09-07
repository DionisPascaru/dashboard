#!/bin/bash

envsubst '$NGINX_ROOT $NGINX_FPM_HOST $NGINX_FPM_PORT' < /etc/nginx/fpm.tmpl > /etc/nginx/conf.d/default.conf
exec nginx -g "daemon off;"

if [ ! -z "$WWWUSER" ]; then
    usermod -u $WWWUSER sail
fi

if [ ! -d /.composer ]; then
    mkdir /.composer
fi

npm install
composer install
php artisan migrate
chmod -R ugo+rw /.composer

if [ ! -z "$PORT" ]; then
    sed -i -e "s/--port=80/--port=$PORT/g" /etc/supervisor/conf.d/supervisord.conf
fi

cat .env | grep -q APP_KEY=base64
if [ ! "$?" -eq 0 ]; then
    php artisan key:generate
fi

if [ $# -gt 0 ];then
    exec gosu $WWWUSER "$@"
else
    /usr/bin/supervisord
fi
