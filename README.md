<p align="center">
    <h1 align="center">Расчет нагрузки преподавателей</h1>
</p>

Расчет нагрузки преподавателей. Аналитика и общие отчеты. Формы документов для печати.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.6.0.


INSTALLATION
------------

```
git clone https://github.com/jerrygacket/dashboards.git
cd dashboards
composer update
```
make config/db_local.php with your db config
```
php yii migrate
php yii migrate --migrationPath=@yii/rbac/migrations
```
* setup virtual host with server_root = project_dir/web
* go to http://virtualhostname/rbac/gen to generate and assign roles
* there are must be a blank page.
* go to http://virtualhostname and you see a login form if everything is ok

