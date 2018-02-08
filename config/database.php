<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',                        //数据库的类型
            'host' => env('DB_HOST', 'localhost'),      //数据库的位置
            'port' => env('DB_PORT', '3306'),           //端口号
            'database' => env('DB_DATABASE', 'security'),  //数据库名
            'username' => env('DB_USERNAME', 'root'),  //用户名
            'password' => env('DB_PASSWORD', 'a123456'),       //密码
            'charset' => 'utf8',                        //字符集
            'collation' => 'utf8_general_ci',           //排序方式
            'prefix' => 'xn_',                         //前缀
            'strict' => true,                           //Strict模式
            'engine' => null,                           //引擎
        ],

        'mysql_testing' => [
            'driver' => 'mysql',                        //数据库的类型
            'host' => env('DB_HOST', 'localhost'),      //数据库的位置
            'port' => env('DB_PORT', '3306'),           //端口号
            'database' => 'test-security',  //数据库名
            'username' => env('DB_USERNAME', 'root'),  //用户名
            'password' => env('DB_PASSWORD', 'a123456'),       //密码
            'charset' => 'utf8',                        //字符集
            'collation' => 'utf8_general_ci',           //排序方式
            'prefix' => 'hb_',                             //前缀
            'strict' => true,                           //Strict模式
            'engine' => null,                           //引擎
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default-'.env('QUEUE_PRE', 't') => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
