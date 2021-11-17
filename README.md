Handmade Web & Design's personal perference for starting Statamic projects.

## Installation
First clone this project then run the composer create-env command.
```shell
composer create-env
```
This will create the `.env` file, modify/update the database details if needed.

```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=statamic_project-starter
DB_USERNAME=root
DB_PASSWORD=
```

Then run the below commands.
```shell
composer install && composer project-install
```

This should install all composer packages and then run artisan storage:link and artisan migrate.

Then you will likely need to create a user account.
```shell
php please make:user
```

# MAMP
If you are using MAMP to provide your database, you may need to update the host from `localhost` to `127.0.0.1`
```env
DB_HOST=127.0.0.1
```

# Docker/Sail
It is also possible to run this via docker/sail.
Edit the env to
```env
DB_HOST=mariadb
DB_PORT=3309
```
And
```env
REDIS_PORT=6380
```

Then run `sail up`
