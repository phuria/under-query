# Phuria SQL Builder 
[![Build Status](https://img.shields.io/scrutinizer/build/g/phuria/sql-builder.svg?maxAge=3600)](https://scrutinizer-ci.com/g/phuria/sql-builder/build-status/master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/phuria/sql-builder.svg?maxAge=3600)](https://scrutinizer-ci.com/g/phuria/sql-builder/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/phuria/sql-builder.svg?maxAge=3600)](https://scrutinizer-ci.com/g/phuria/sql-builder/?branch=master)
[![Packagist](https://img.shields.io/packagist/v/phuria/sql-builder.svg?maxAge=3600)](https://packagist.org/packages/phuria/sql-builder)
[![license](https://img.shields.io/github/license/phuria/sql-builder.svg?maxAge=2592000?style=flat-square)]()
[![php](https://img.shields.io/badge/PHP-5.6-blue.svg?maxAge=2592000)]()

The Phuria SQL Query Builder is focused on:
 + object-oriented inheritance behavior in database's tables
 + possibility of doing everything that can be done in native syntax
 + being lightweight and fast (also in development)
 + easily to extend

```
composer require phuria/sql-builder
```


## Content

- [1. Quick Start](#1-quick-start) 
  - [1.1 Simple SELECT](#11-simple-select)
  - [1.2 Single Table DELETE](#12-single-table-delete)
  - [1.3 Multiple Table DELETE](#13-multiple-table-delete)
  - [1.4 Simple INSERT](#14-simple-insert)
  - [1.5 INSERT ... SELECT](#15-insert--select)
  - [1.6 Simple UPDATE](#16-simple-update)
- [2. Table Reference](#2-table-reference)
- [3. Column Reference](#3-column-reference)
- [4. Creating custom table class](#4-creating-custom-table-class)
- [5. Configuration](#5-configuration)
  - [5.1 Registering custom table class](#51-registering-custom-table-class)
- [6. SQL Clauses](#6-sql-clauses)
  - [6.1 JOIN Clause](#61-join-clause)
    - [6.1.1 OUTER and NATURAL JOIN](#611-outer-and-natural-join)
  - [6.2 WHERE Clause](#62-where-clause)
  - [6.3 GROUP BY Clause](#63-group-by-clause)
    - [6.3.1 GROUP BY ... WITH ROLLUP](#631-group-by--with-rollup)
  - [6.4 HAVING Clause](#64-having-clause)
  - [6.5 ORDER BY Clause](#65-order-by-clause)
  - [6.6 LIMIT Clause](#66-limit-clause)
- [7. Advanced query examples](#7-select-query)
  - [7.1 UPDATE Query](#71-update-query)
  - [7.2 INSERT Query](#72-insert-query)
  - [7.3 INSERT ... SELECT Query](#73-insert--select-query)
  - [7.4 DELETE Query](#74-delete-query)
  - [7.5 SELECT Query](#75-select-query)
- [8. Sub Query](#8-sub-query)



## 1. Quick start

There are different query builder classes for each SQL query type: 
`SelectBuilder`, `UpdateBuilder`, `DeleteBuilder` and `InsertBuilder`.
To create them we will use our factory:

```php
$qbFactory = new \Phuria\SQLBuilder\QueryBuilderFactory();
```

### 1.1 Simple SELECT
```php
$qb = $qbFactory->createSelect();

$qb->addSelect('u.name', 'c.phone_number');
$qb->from('user', 'u');
$qb->leftJoin('contact', 'c', 'u.id = c.user_id');

echo $qb->buildSQL();
```

```sql
SELECT u.name, c.phone_number FROM user AS u LEFT JOIN contact AS c ON u.id = c.user_id;
```

### 1.2 Single Table DELETE
```php
$qb = $qbFactory->createDelete();

$qb->from('user');
$qb->andWhere('id = 1');

echo $qb->buildSQL();
```

```sql
DELETE FROM user WHERE id = 1;
```

### 1.3 Multiple Table DELETE
```php
$qb = $qbFactory->createDelete();

$qb->from('user', 'u');
$qb->innerJoin('contact', 'c', 'u.id = c.user_id')
$qb->addDelete('u', 'c');
$qb->andWhere('u.id = 1');

echo $qb->builidSQL();
```

```sql
DELETE u, c FROM user u LEFT JOIN contact c ON u.id = c.user_id WHERE u.id = 1 
```

### 1.4 Simple INSERT
```php
$qb = $qbFactory->createInsert();

$qb->into('user', 'u', ['username', 'email']);
$qb->addValues(['phuria', 'spam@simko.it']);

echo $qb->buildSQL();
```

```sql
INSERT INTO user (username, email) VALUES ("phuria", "spam@simko.it")
```

### 1.5 INSERT ... SELECT
```php
$sourceQb = $qbFactory->createInsert();

$sourceQb->from('transactions', 't');
$sourceQb->addSelect('t.user_id', 'SUM(t.amount)');
$sourceQb->addGroupBy('t.user_id');

$targetQb = $qbFactory->createInsertSelect();
$targetQb->into('user_summary', ['user_id', 'total_price']);
$targetQb->selectInsert($sourceQb);

echo $targetQb->buildSQL();
```

```sql
INSERT INTO user_summary (user_id, total_price) SELECT t.user_id, SUM(t.amount) FROM transactions AS t GROUP BY t.user_id
```

### 1.6 Simple UPDATE
```php
$qb = $qbFactory->createUpdate();

$rootTable = $qb->update('user', 'u');
$qb->addSet("u.updated_at = NOW()");
$qb->andWhere("u.id = 1");
```

```sql
UPDATE user AS u SET u.updated_at = NOW() WHERE u.id = 1
```



## 2. Table Reference

Methods adding tables (such as `leftJoin`, `from`, `into`) 
return `TableInterface` \ `AbstractTable` instance. Use `AbstractTable` like string will convert 
this object to reference. All references will be converted to table name (or alias).
It allows you to easily change aliases.

```php
$qb = $qbFactory->createSelect();

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



## 3. Column Reference

Table reference is the most commonly used in table's column context. 
Therefore, here is helper method that which returns reference directly to column.

```php
$qb = $qbFactory->createSelect();

$userTable = $qb->from('user', 'u');
$qb->addSelect($userTable->column('username'), $userTable->column('password'));

echo $qb->buildSQL();
```

```sql
SELECT u.username, u.password FROM user u
```



## 4. Creating custom table class

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
$qb = $qbFactory->createSelect();

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



## 5. Configuration

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
use Phuria\SQLBuilder\QueryBuilderFactory;

$qbFactory = new QueryBuilderFactory($container);
```

### 5.1 Registering custom table class

```php
$registry = $container['phuria.sql_builder.table_registry'];
$registry->registerTable($tableClass, $tableName)
```

Argument `$tableClass` must be fully-qualified class name,
`$tableName` must be full name of database table.



## 6. SQL Clauses

### 6.1 JOIN Clause

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

#### 6.1.1 OUTER and NATURAL JOIN

To determine join as `OUTER` or `NATURAL` use methods: 
`AbstractTable::setNaturalJoin()` or `AbstractTable::setOuterJoin()`

```php
$userTable = $qb->leftJoin('user', 'u');
$userTable->setNaturalJoin(true);
$userTable->setOuterJoin(true);
```

### 6.2 WHERE Clause

```php
$qb->andWhere('u.active = 1');
$qb->andWhere('u.email IS NOT NULL');
```

```sql
WHERE u.active = 1 AND u.email IS NOT NULL
```

### 6.3 GROUP BY Clause

```php
$qb->addGroupBy('YEAR(u.creaded_at) ASC');
$qb->addGroupBy('u.affiliate_id');
```

```sql
GROUP BY YEAR(u.country_id) ASC, u.affiliate_id
```

#### 6.3.1 GROUP BY ... WITH ROLLUP

For use the `WITH ROLLUP` clause, use `setGroupByWithRollUp(true)`:

```php
$qb->addGroupBy('u.country_id');
$qb->addGroupBy('u.male');
$qb->setGroupByWithRollUp(true);
```

```sql
GROUP BY u.country_id, u.male WITH ROLLUP
```

### 6.4 HAVING Clause

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

### 6.5 ORDER BY Clause

```php
$qb->addOrderBy('u.last_name ASC');
$qb->addOrderBy('u.first_name ASC');
```

```sql
ORDER BY u.last_name ASC, u.first_name ASC
```

### 6.6 LIMIT Clause

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



## 7. Advanced Query examples

### 7.1 UPDATE Query

```php
$sourceQb = $queryFactory->createSelect();
$sourceQb->addSelect('i.transactor_id');
$sourceQb->addSelect('SUM(i.gross) AS gross');
$sourceQb->addSelect('SUM(i.net) AS net');
$sourceQb->from('invoice', 'i');
$sourceQb->addGroupBy('i.transactor_id');

$qb = $queryFactory->update();

$qb->update('transactor_summary', 'summary');
$qb->innerJoin($sourceQb, 'source', 'summary.transactor_id = source.transactor_id');
$qb->addSet('summary.invoiced_gross = source.gross');
$qb->addSet('summary.invoiced_net = source.net');

echo $qb->buildSQL();
```

```sql
UPDATE transactor_summary AS summary INNER JOIN (...) AS source
SET summary.invoiced_gross = source.gross, summary.invoiced_net = source.net
```

```php
$qb = $queryFactory->createUpdate();

$qb->update('players', 'p');
$qb->addSet('p.qualified = 1');
$qb->andWhere('p.league = 20');
$qb->addOrderBy('p.major_points DESC, p.minior_points DESC');
$qb->addLimit(20);

echo $qb->buildSQL();
```

```sql
UPDATE players AS p SET p.qualified = 1 WHERE p.league = 20 ORDER BY p.major_points DESC, p.minior_points DESC LIMIT 20
```

### 7.2 INSERT Query



## 8. Sub Query

To use a sub query like table, pass it as argument (instead of the name of the table).
You will get in return an instance of `SubQueryTable` 
that you can use like normal table (eg. you can set alias).
 
```php
$qb = $qbFactory->createSelect();
$subQb->addSelect('MAX(pricelist.price) AS price');
$subQb->from('pricelist');
$subQb->addGroupBy('pricelist.owner_id');

$qb = $qbFactory->createSelect();
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
$qb = $qbFactory->createSelect();
$subQb->addSelect('DISTINCT user.affiliate_id');
$subQb->form('user');

$qb = $qbFactory->createSelect();
$qb->addSelect("10 = ({$qb->objectToString($subQb)})");

echo $qb->buildSQL();
```

```sql
SELECT 10 IN (SELECT DISTINCT user.affiliate_id FROM user)
```

At the time of building query `RefereneParser` will be known what to do with it.
