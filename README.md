# Phuria SQL Builder 
[![Build Status](https://img.shields.io/scrutinizer/build/g/phuria/sql-builder.svg?maxAge=2592000)](https://scrutinizer-ci.com/g/phuria/sql-builder/build-status/master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/phuria/sql-builder.svg?maxAge=2592000)](https://scrutinizer-ci.com/g/phuria/sql-builder/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/phuria/sql-builder.svg?maxAge=2592000)](https://scrutinizer-ci.com/g/phuria/sql-builder/?branch=master)
[![GitHub release](https://img.shields.io/github/release/phuria/sql-builder.svg?maxAge=2592000?style=flat-square)]()
[![license](https://img.shields.io/github/license/phuria/sql-builder.svg?maxAge=2592000?style=flat-square)]()
[![php](https://img.shields.io/badge/PHP-5.6-blue.svg)]()

SQL query builder focused on:
 + object-oriented inheritance behavior in database's tables
 + possibility of doing everything that can be done in native syntax
 + being lightweight and fast (also in development)
 + easily to extend

```sh
php composer.phar require phuria/sql-builder
```


## Quick start

There are different query builder classes for each SQL query type: 
`SelectBuilder`, `UpdateBuilder`, `DeleteBuilder` and `InsertBuilder`.
To create them we will use our factory:

```php
$qbFactory = new Phuria\SQLBuilder\QueryBuilder();
```


#### Simple SELECT
```php
$qb = $qbFactory->select();

$qb->addSelect('u.name', 'c.phone_number');
$qb->from('user', 'u');
$qb->leftJoin('contact', 'c', 'u.id = c.user_id');

echo $qb->buildSQL();
```

```sql
SELECT u.name, c.phone_number FROM user AS u LEFT JOIN contact AS c ON u.id = c.user_id;
```

#### Single Table DELETE
```php
$qb = $qbFactory->delete();

$qb->from('user');
$qb->andWhere('id = 1');

echo $qb->buildSQL();
```

```sql
DELETE FROM user WHERE id = 1;
```

#### Multiple Table DELETE
```php
$qb = $qbFactory->delete();

$qb->from('user', 'u');
$qb->innerJoin('contact', 'c', 'u.id = c.user_id')
$qb->addDelete('u', 'c');
$qb->andWhere('u.id = 1');

echo $qb->builidSQL();
```

```sql
DELETE u, c FROM user u LEFT JOIN contact c ON u.id = c.user_id WHERE u.id = 1 
```

#### Simple INSERT
```php
$qb = $qbFactory->insert();

$qb->into('user', 'u', ['username', 'email']);
$qb->addValues(['phuria', 'spam@simko.it']);

echo $qb->buildSQL();
```

```sql
INSERT INTO user (username, email) VALUES ("phuria", "spam@simko.it")
```

#### INSERT ... SELECT
```php
$sourceQb = $qbFactory->insert();

$sourceQb->from('transactions', 't');
$sourceQb->addSelect('t.user_id', 'SUM(t.amount)');
$sourceQb->addGroupBy('t.user_id');

$targetQb = $qbFactory->insertSelect();
$targetQb->into('user_summary', ['user_id', 'total_price']);
$targetQb->selectInsert($sourceQb);

echo $targetQb->buildSQL();
```

```sql
INSERT INTO user_summary (user_id, total_price) SELECT t.user_id, SUM(t.amount) FROM transactions AS t GROUP BY t.user_id
```

#### Simple UPDATE
```php
$qb = $qbFactory->update();

$rootTable = $qb->update('user', 'u');
$qb->addSet("u.updated_at = NOW()");
$qb->andWhere("u.id = 1");
```

```sql
UPDATE user AS u SET u.updated_at = NOW() WHERE u.id = 1
```


## Table reference

Methods adding tables (such as `leftJoin`, `from`, `into`) 
return `TableInterface` \ `AbstractTable` instance. Use `AbstractTable` like string will convert 
this object to reference. All references will be converted to table name (or alias).
It allows you to easily change aliases.

```php
$qb = $qbFactory->select();

$userTable = $qb->from('user');
$qb->select("{$userTable}.*");

// Without alias
echo $qb->buildSQL();

$userTable->setAlias('u');

// With alias
echo $qb->buildSQL();
```

```sql
# Without alias
SELECT user.* FROM user;

# With alias
SELECT u.* FROM user AS u;
```


## Column reference

Table reference is the most commonly used in table's column context. 
Therefore, here is helper method that which returns reference directly to column.

```php
$qb = $qbFactory->select();

$userTable = $qb->from('user', 'u');
$qb->addSelect($userTable->column('username'), $userTable->column('password'));

echo $qb->buildSQL();
```

```sql
SELECT u.username, u.password FROM user u
```


## Create your own custom table

The default implementation of `TableInterface` is `UnknownTable`. For mapping table name to class name is responsible `TableRegistry`. 

First you need to crete implementation of `TableInterface`. We highly recommend inheriting from `AbstractTable`.

```php
use Phuria\SQLBuilder\Table\AbstractTable;

class AccountTable extends AbstractTable
{
    public function getTableName()
    {
        return 'account';
    }
    
    public function onlyActive()
    {
        $this->getQueryBuilder()->andWhere($this->column('active'));
    }
    
    public function joinToContact()
    {
        $qb = $this->getQueryBuilder();
        $userTable = $qb->innerJoin('user', 'u');
        $userTable->joinOn("{$userTable}.id = {$this}.user_id");
        $contactTable = $qb->innerJoin('contact', 'c');
        $contactTable->joinOn("{$contactTable}.user_id = {$userTable}.id");
        
        return $contactTable;
    }
    
    public function selectOnlyActiveEmails()
    {
        $this->onlyActive();
        $contactTable = $this->joinToContact();
        $this->getQueryBuilder()->addSelect($contactTable->column('email'));
        
        return $this; 
    }
}
```

Then you need to add the table to configuration (see configuration section). 
Now when you are referring to this table, you get instance of implemented class.

```php
$qb = $qbFactory->select();

$qb->addSelect('*');

$accountTable = $qb->from('account');
$accountTable->onlyActive();

$qb->buildSQL();
```

```sql
SELECT * FROM account WHERE acount.active
```

You are not in any way obligated to use this functionality.
But think how much it can facilitate you to build complex queries.



## Configuration

#### Static QB

The __easiest__ and __not recommended__ way to configure this library is use `\Phuria\SQLBuilder\QB` class.
Here you get access to `InternalContainer` and you can make the necessary changes.
Reconfigured container instance will be delivered to every new query builder (you must use static factory methods).

Example how to register table:

```php
use Phuria\SQLBuilder\QB;

$tableRegistry = QB::getContainer()->get('phuria.sql_builder.table_registry');
$tableRegistry->registerTable('example_table', ExampleTable::class);

$qb = QB::select();

echo get_class($qb->from('example_table')); // output: ExampleTable::class
```


#### Use InternalContainer in your own DependencyInjection

Another way is add an `InternalContainer` as service to your own DI. 
You will probably need to implement query builder factory.

```php
use Phuria\SQLBuilder\DependencyInjection\InternalContainer;
use Phuria\SQLBuilder\QueryBuilder\SelectBuilder;

class MyQueryBuilderFactory
{
    private $internalContainer;
    
    public function __construct()
    {
        $this->internalContainer = new InternalContainer();
    }
    
    public function addTableToRegistry($tableName, $tableClass)
    {
        $this->internalContainer->get('phuria.sql_builder.table_registry')
            ->tableRegister($tableName, $tableClass);
    }
    
    public function createSelectBuilder()
    {
        return new SelectBuilder($this->internalContainer);
    }
}
```

#### Use directly your own DependencyInjection

We recommend spending some time and add all services and parameters to your `Container`. 
All necessary dependency data can be found in `InternalContainer`'s constructor.


## Joins

To create join, use one of the following methods: 
`join`, `innerJoin`, `leftJoin`, `rightJoin`, `straightJoin` or `crossJoin`.

Join method signature looks like this:
```php
join($table, string $alias = null, string $joinOn = null) : TableInterface
```

Argument `$table` can be one of following types:
 - table name
 - class name
 - closure
 - object implementing `QueryBuilderInterface`

```php
$qb = $qbFactory->select();

// Table name:
$qb->join('account');

// Class name:
$qb->join(AccountTable::class);

// Closure:
$qb->join(function (AccountTable $accountTable) { 
    
});

// Another QueryBuilder:
$anotherQb = $qbFactory->select();
$qb->join($anotherQb);
```

Arguments `$alias` and `$joinOn` are optional.
You can set them later directly on the object table.

```php
$qb = $qbFatry->select();
$qb->from('user', 'u');
$qb->join('account', 'a', 'u.id = a.user_id');
```
OR
```php
$qb = $qbFatry->select();
$userTable = $qb->from('user', 'u');
$accountTable = $qb->join('account');
$accountTable->setAlias('a');
$accountTable->joinOn("{$userTable->column('id')} = {$accountTable->column('user_id')}");
```

## Sub Query

To use a sub query like table, pass it as argument (instead of the name of the table).
You will get in return an instance of `SubQueryTable` that you can use like normal table (eg. you can set alias).
 
```php
$qb = $qbFactory->select();
$subQb->addSelect('MAX(pricelist.price) AS price');
$subQb->from('pricelist');
$subQb->addGroupBy('pricelist.owner_id');

$qb = $qbFactory->select();
$subTable = $qb->from($subQb, 'src');
$qb->addSelect("AVG({$subTable->column('price')})");

echo $qb->buildSQL();
```

```sql
SELECT AVG(src.price) FROM (SELECT MAX(pricelist.price) AS price FROM pricelist GROUP BY pricelist.owner_id) AS src
```

If you want to use sub query in a different context then you must use object to string reference converter.

```php
$qb = $qbFactory->select();
$subQb->addSelect('DISTINCT user.affiliate_id');
$subQb->form('user');

$qb = $qbFactory->select();
$qb->addSelect("10 = ({$qb->objectToString($subQb)})");

echo $qb->buildSQL();
```

```sql
SELECT 10 IN (SELECT DISTINCT user.affiliate_id FROM user)
```

At the time of building query `RefereneParser` will be known what to do with it.