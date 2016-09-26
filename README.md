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
 + easily to extend and modify

```sh
php composer.phar require phuria/sql-builder
```


## Quick start

There are different query builders classes for each SQL query type: `SelectBuilder`, `UpdateBuilder`, `DeleteBuilder` and `InsertBuilder`.


```php
$qb = new SelectBuilder();

$qb->addSelect('u.name, c.phone_number');
$qb->from('user')->alias('u');
$qb->leftJoin('contact')->aliac('c')->on('u.id = c.user_id');

echo $qb->buildSQL();
```

```sql
SELECT u.name, c.phone_number FROM user AS u LEFT JOIN contact AS c ON u.id = c.user_id;
```


__Custom table__

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

