# Phuria SQLBuilder [![Build Status](https://travis-ci.org/phuria/sql-builder.svg?branch=master)](https://travis-ci.org/phuria/sql-builder)

### Requirements

PHP: `>=5.6.0`

### Simple Examples

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