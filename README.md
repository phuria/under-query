# Phuria SQL Builder 
[![Build Status](https://img.shields.io/scrutinizer/build/g/phuria/sql-builder.svg?maxAge=3600)](https://scrutinizer-ci.com/g/phuria/sql-builder/build-status/master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/phuria/sql-builder.svg?maxAge=3600)](https://scrutinizer-ci.com/g/phuria/sql-builder/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/phuria/sql-builder.svg?maxAge=3600)](https://scrutinizer-ci.com/g/phuria/sql-builder/?branch=master)
[![Packagist](https://img.shields.io/packagist/v/phuria/sql-builder.svg?maxAge=3600)](https://packagist.org/packages/phuria/sql-builder)
[![license](https://img.shields.io/github/license/phuria/sql-builder.svg?maxAge=2592000?style=flat-square)]()
[![php](https://img.shields.io/badge/PHP-5.6-blue.svg?maxAge=2592000)]()

SQL query builder focused on:
 + object-oriented inheritance behavior in database's tables
 + possibility of doing everything that can be done in native syntax
 + being lightweight and fast (also in development)
 + easily to extend

```
composer require phuria/sql-builder
```



## Content

- [Quick start](#quick-start) 
- [Table reference](#table-reference)
- [Column reference](#column-reference)
- [Creating custom table class](#creating-custom-table-class)
- [Configuration](#configuration)
  - [Registering custom table class](#registering-custom-table-class)
- [Sub Query](#sub-query)
- [JOIN Clause](#join-clause)
  - [OUTER and NATURAL JOIN](#outer-and-natural-join)
- [WHERE Clause](#where-clause)
- [GROUP BY Clause](#group-by-clause)
  - [GROUP BY ... WITH ROLLUP](#group-by--with-rollup)
- [HAVING Clause](#having-clause)
- [ORDER BY Clause](#order-by-clause)
- [LIMIT Clause](#limit-clause)



## Quick start

There are different query builder classes for each SQL query type: 
`SelectBuilder`, `UpdateBuilder`, `DeleteBuilder` and `InsertBuilder`.
To create them we will use our factory:

```php
$qbFactory = new \Phuria\SQLBuilder\QueryBuilder();
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




## Creating custom table class

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

To resolve dependency in this library 
has been used `Container` from `pimple/pimple` package.

To create `Container` with default configuration, use `ContainerFactory`:

```php
use Phuria\SQLBuilder\DependencyInjection\ContainerFactory;

$containerFactory = ContinerFactory();
$container = $containerFactory->create();
```

Now you can make changes. At the end do not forget to pass the `Container` instance 
to `QueryBuilder`:

```php
use Phuria\SQLBuilder\QueryBuilder;

$queryBuilderFactory = new QueryBuilder($container);
```

#### Registering custom table class

```php
$registry = $container['phuria.sql_builder.table_registry'];
$registry->registerTable($tableClass, $tableName)
```

Argument `$tableClass` must be fully-qualified class name,
`$tableName` must be full name of database table.




## Sub Query

To use a sub query like table, pass it as argument (instead of the name of the table).
You will get in return an instance of `SubQueryTable` 
that you can use like normal table (eg. you can set alias).
 
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

If you want to use sub query in a different context 
then you must use object to string reference converter.

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





## JOIN Clause

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
// Table name:
$qb->join('account');

// Class name:
$qb->join(AccountTable::class);

// Closure:
$qb->join(function (AccountTable $accountTable) { 
    
});

// Another QueryBuilder:
$qb->join($anotherQb);
```

Arguments `$alias` and `$joinOn` are optional.
You can set them later directly on the object table.
```php
$qb->from('user', 'u');
$qb->join('account', 'a', 'u.id = a.user_id');
```
And equivalent code:
```php
$userTable = $qb->from('user', 'u');
$accountTable = $qb->join('account');
$accountTable->setAlias('a');
$accountTable->joinOn("{$userTable->column('id')} = {$accountTable->column('user_id')}");
```

#### OUTER and NATURAL JOIN

To determine join as `OUTER` or `NATURAL` use methods: 
`AbstractTable::setNaturalJoin()` or `AbstractTable::setOuterJoin()`

```php
$userTable = $qb->leftJoin('user', 'u');
$userTable->setNaturalJoin(true);
$userTable->setOuterJoin(true);
```




## WHERE Clause

```php
$qb->andWhere('u.active = 1');
$qb->andWhere('u.email IS NOT NULL');
```

```sql
WHERE u.active = 1 AND u.email IS NOT NULL
```




## GROUP BY Clause

```php
$qb->addGroupBy('YEAR(u.creaded_at) ASC');
$qb->addGroupBy('u.affiliate_id');
```

```sql
GROUP BY YEAR(u.country_id) ASC, u.affiliate_id
```

#### GROUP BY ... WITH ROLLUP

For use the `WITH ROLLUP` clause, use `setGroupByWithRollUp(true)`:

```php
$qb->addGroupBy('u.country_id');
$qb->addGroupBy('u.male');
$qb->setGroupByWithRollUp(true);
```

```sql
GROUP BY u.country_id, u.male WITH ROLLUP
```




## HAVING Clause

```php
$qb->addSelect('SUM(i.gross) AS gross');
$qb->addSelect('i.transactor_id');
$qb->from('invoice', 'i');
$qb->addGroupBy('i.transactor_id'):
$qb->andHaving('gross > 1000');
```

```sql
SELECT SUM(i.gross) AS gross, i.transactor_id FROM invoice AS i GROUP BY i.transactor_id HAVING gross > 1000
```




## ORDER BY Clause

```php
$qb->addOrderBy('u.last_name ASC');
$qb->addOrderBy('u.first_name ASC');
```

```sql
ORDER BY u.last_name ASC, u.first_name ASC
```




## LIMIT Clause

```php
$qb->setLimit(10);
$qb->setLimit('10, 20');
$qb->setLimit('10 OFFSET 20');
```

```sql
LIMIT 10
LIMIT 10, 20
LIMIT 10 OFFSET 20
```