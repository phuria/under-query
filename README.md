# Phuria SQL Builder [![Build Status](https://travis-ci.org/phuria/sql-builder.svg?branch=master)](https://travis-ci.org/phuria/sql-builder)

### Requirements

PHP: `>=5.6.0`

### Examples

1. Simple Query

```php
$qb = new QueryBuilder();

$userTable = $qb->from('user');
$qb->addSelect($userTable->column('name'));
$userTable->setAlias('u');

$contactTable = $qb->leftJoin('contact');
$qb->addSelect($contactTable->column('phone_number');
$contactTable->setAlias('c');
$contactTable->joinOn(
    $userTable->column('id')->eq($contactTable->column('user_id'))
);

$sql = $qb->buildSQL();
```

```sql
SELECT u.name, c.phone_number FROM user AS u
LEFT JOIN contact AS c ON u.id = c.user_id;
```

### Aggregate functions

```php
$qb = new QueryBuilder();

$priceListTable = $qb->from('pirce_list');
$qb->addSelect($qb->column('price')->sumNullable()->alias('price'));

$sql = $qb->getSQL();
```

```sql
SELECT SUM(IFNULL(price_list.price, 0)) AS price FROM price_list
```

### String functions

```php
$qb = new QueryBuilder();

$qb->addSelect(
    $qb->expr(10, 30, 40, $qb->expr('utf8')->using())->char()
);

$sql = $qb->buildSQL();
```

```sql
SELECT CHAR(10, 30, 40 USING utf8)
```