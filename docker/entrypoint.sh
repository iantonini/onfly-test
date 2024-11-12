#!/bin/sh
cd /api;
composer install;
php bin/hyperf.php migrate;
php bin/hyperf.php migrate:status;
php bin/hyperf.php db:seed;
php vendor/bin/phpunit;
php bin/hyperf.php server:watch;
