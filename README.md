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

Below are some simple examples of use.

#### Simple SELECT
```php
$qb = new SelectBuilder();

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

#### Simple INSERT
```php
$qb = new InsertBuilder();

$qb->into('user', 'u', ['username', 'email']);
$qb->addValues(['phuria', 'spam@simko.it']);

echo $qb->buildSQL();
```

```sql
INSERT INTO user (username, email) VALUES ("phuria", "spam@simko.it")
```

#### INSERT ... SELECT
```php
$sourceQb = new SelectBuilder();

$sourceQb->from('transactions', 't');
$sourceQb->addSelect('t.user_id', 'SUM(t.amount)');
$sourceQb->addGroupBy('t.user_id');

$targetQb = new InsertSelectBuilder();
$targetQb->into('user_summary', ['user_id', 'total_price']);
$targetQb->selectInsert($sourceQb);

echo $targetQb->buildSQL();
```

```sql
INSERT INTO user_summary (user_id, total_price) SELECT t.user_id, SUM(t.amount) FROM transactions AS t GROUP BY t.user_id
```

#### Simple UPDATE
```php
$qb = new UpdateBuilder();

$rootTable = $qb->update('user', 'u');
$qb->addSet("u.updated_at = NOW()");
$qb->andWhere("u.id = 1");
```

```sql
UPDATE user AS u SET u.updated_at = NOW() WHERE u.id = 1
```


## Table reference

Each method adds to QueryBuilder new table (eg. `leftJoin`, `from`, `into`) returns `TableInterface` instance.
Use an instance of such a table as string will convert object to reference.
When is time to build SQL, all references will be converted to table name (or alias).
This allows you to easily change aliases.

```php
$qb = new SelectBuilder();

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
$qb = new SelectBuilder();

$userTable = $qb->from('user', 'u');
$qb->addSelect($userTable->column('username'), $userTable->column('password'));

echo $qb->buildSQL();
```

```sql
SELECT u.username, u.password FROM user u
```


## Create your own custom table

There is example of usage own table objects.

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

