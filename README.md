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
composer install && composer install-project
```

This should run artisan storage:link and artisan migrate.

Then you will probable need to create a user account.
```shell
php please make:user
```