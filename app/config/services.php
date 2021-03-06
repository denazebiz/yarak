<?php

use Yarak\Kernel;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;

$di->setShared('config', function () {
    return include APP_PATH.'/config/config.php';
});

$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\'.$config->database->adapter;

    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset,
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    $connection->setNestedTransactionsWithSavepoints(true);

    return $connection;
});

$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

 $di->set('modelsManager', function () {
     return new ModelsManager();
 });

$di->set('yarak', function () {
    return new Kernel();
});
