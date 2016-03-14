# coursework
Установка

Для установки проекта необходимо:

Скопировать архив проекта, разархивировать в папку

В консоли зайти в папку Protect и выполнить следующие команды:

composer global require "fxp/composer-asset-plugin"
composer install
В папке protected/config необходимо внести свои локальные настройки БД (файл db.php)
В папке protected/config в файл web.php добавить следующее: 
'components' => [
     ...
    'authManager' => [
         'class' => 'yii\rbac\DbManager',
     ],
     ...
]
В "консоле" перейти в папку /protected и выполнить миграцию RBAC и начальную миграцию таблиц
$ yii migrate --migrationPath=@yii/rbac/migrations
$ yii migrate
