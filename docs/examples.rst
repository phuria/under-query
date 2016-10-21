Examples
========

There are different query builder classes for each SQL query type:
`SelectBuilder`, `UpdateBuilder`, `DeleteBuilder` and `InsertBuilder`.
To create them we will use our factory:

.. code-block:: php
    $phuriaSQL = new \Phuria\SQLBuilder\PhuriaSQLBuilder();

Simple SELECT
-------------

.. code-block:: php

    $qb = $phuriaSQL->createSelect();

    $qb->addSelect('u.name', 'c.phone_number');
    $qb->from('user', 'u');
    $qb->leftJoin('contact', 'c', 'u.id = c.user_id');

    echo $qb->buildSQL();

.. code-bock:: sql

    SELECT u.name, c.phone_number FROM user AS u LEFT JOIN contact AS c ON u.id = c.user_id;

Single Table DELETE
-------------------

.. code-block:: php

    $qb = $phuriaSQL->createDelete();

    $qb->from('user');
    $qb->andWhere('id = 1');

    echo $qb->buildSQL();

.. code-block:: sql

    DELETE FROM user WHERE id = 1;

Multiple Table DELETE
---------------------

.. code-block:: php

    $qb = $phuriaSQL->createDelete();

    $qb->from('user', 'u');
    $qb->innerJoin('contact', 'c', 'u.id = c.user_id')
    $qb->addDelete('u', 'c');
    $qb->andWhere('u.id = 1');

    echo $qb->buildSQL();

.. code-block:: sql

    DELETE u, c FROM user u LEFT JOIN contact c ON u.id = c.user_id WHERE u.id = 1

Simple INSERT
-------------

.. code-block:: php

    $qb = $phuriaSQL->createInsert();

    $qb->into('user', 'u', ['username', 'email']);
    $qb->addValues(['phuria', 'spam@simko.it']);

    echo $qb->buildSQL();

.. code-block:: sql

    INSERT INTO user (username, email) VALUES ("phuria", "spam@simko.it")

INSERT ... SELECT
-----------------

.. code-block:: php

    $sourceQb = $phuriaSQL->createInsert();

    $sourceQb->from('transactions', 't');
    $sourceQb->addSelect('t.user_id', 'SUM(t.amount)');
    $sourceQb->addGroupBy('t.user_id');

    $targetQb = $phuriaSQL->createInsertSelect();
    $targetQb->into('user_summary', ['user_id', 'total_price']);
    $targetQb->selectInsert($sourceQb);

    echo $targetQb->buildSQL();

.. code-block:: sql

    INSERT INTO user_summary (user_id, total_price)
    SELECT t.user_id, SUM(t.amount) FROM transactions AS t GROUP BY t.user_id

Simple UPDATE
-------------

.. code-block:: php

    $qb = $phuriaSQL->createUpdate();

    $rootTable = $qb->update('user', 'u');
    $qb->addSet("u.updated_at = NOW()");
    $qb->andWhere("u.id = 1");

    echo $qb->buildSQL();

.. code-block:: sql

    UPDATE user AS u SET u.updated_at = NOW() WHERE u.id = 1

