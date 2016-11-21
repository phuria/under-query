Object References
=================

Table Reference
---------------

Methods adding tables (such as `leftJoin`, `from`, `into`)
return `TableInterface` \ `AbstractTable` instance. Use `AbstractTable` like string will convert
this object to reference. All references will be converted to table name (or alias).
It allows you to easily change aliases.

.. code-block:: php

    $qb = $qbFactory->createSelect();

    $userTable = $qb->from('user');
    $qb->select("{$userTable}.*");

    // Without alias
    echo $qb->buildSQL();

    $userTable->setAlias('u');

    // With alias
    echo $qb->buildSQL();

.. code-block:: mysql

    # Without alias
    SELECT user.* FROM user;

    # With alias
    SELECT u.* FROM user AS u;

Column Reference
----------------

Table reference is the most commonly used in table's column context.
Therefore, here is helper method that returns reference directly to column.

.. code-block:: php

    $qb = $qbFactory->createSelect();

    $userTable = $qb->from('user', 'u');
    $qb->addSelect($userTable->column('username'), $userTable->column('password'));

    echo $qb->buildSQL();

.. code-block:: mysql

    SELECT u.username, u.password FROM user u

