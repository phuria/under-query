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

There are different query builders classes for each SQL query type: `SelectBuilder`, `UpdateBuilder`, `DeleteBuilder` and `InsertBuilder`.

#### Simple SELECT
```php
$qb = new SelectBuilder();

$qb->addSelect('u.name, c.phone_number');
$qb->from('user')->alias('u');
$qb->leftJoin('contact')->alias('c')->on('u.id = c.user_id');

echo $qb->buildSQL();
```

```sql
SELECT u.name, c.phone_number FROM user AS u LEFT JOIN contact AS c ON u.id = c.user_id;
```

#### Single Table DELETE
```php
$qb = new DeleteBuilder();

$qb->from('user');
$qb->andWhere('id = 1');

echo $qb->buildSQL();
```

```sql
DELETE FROM user WHERE id = 1;
```

#### Multiple Table DELETE
```php
$qb = new DeleteBuilder();

$qb->from('user', 'u');
$qb->innerJoin('contact', 'c', 'u.id = c.user_id')
$qb->addDelete('u', 'c');
$qb->andWhere('u.id = 1');

echo $qb->builidSQL();
```

```sql
DELETE u, c FROM user u LEFT JOIN contact c ON u.id = c.user_id WHERE u.id = 1 
```

## Create your own custom table

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
        $this->andWhere($this->column('active'));
    }
}
```

```php
$qb = new QueryBuilder();
$qb->addSelect('*');

$accountTable = $qb->from('account');
$accountTable->onlyActive();

$qb->buildSQL();
```

```sql
SELECT * FROM account WHERE acount.active
```

