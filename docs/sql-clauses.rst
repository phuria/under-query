SQL Clauses
-----------

JOIN Clause
-----------

To create join, use one of the following methods:
`join`, `innerJoin`, `leftJoin`, `rightJoin`, `straightJoin` or `crossJoin`.

Join method signature looks like this:

.. code-block:: php

    join($table, string $alias = null, string $joinOn = null) : TableInterface

Argument `$table` can be one of following types:
 - table name
 - class name
 - closure
 - object implementing `QueryBuilderInterface`

.. code-block:: php

    // Table name:
    $qb->join('account');

    // Class name:
    $qb->join(AccountTable::class);

    // Closure:
    $qb->join(function (AccountTable $accountTable) {

    });

    // Another QueryBuilder:
    $qb->join($anotherQb);

Arguments `$alias` and `$joinOn` are optional.
You can set them later directly on the object table.

.. code-block:: php

    $qb->from('user', 'u');
    $qb->join('account', 'a', 'u.id = a.user_id');


And equivalent code:

.. code-block:: php

    $userTable = $qb->from('user', 'u');
    $accountTable = $qb->join('account');
    $accountTable->setAlias('a');
    $accountTable->joinOn("{$userTable->column('id')} = {$accountTable->column('user_id')}");


OUTER and NATURAL JOIN
~~~~~~~~~~~~~~~~~~~~~~

To determine join as `OUTER` or `NATURAL` use methods:
`AbstractTable::setNaturalJoin()` or `AbstractTable::setOuterJoin()`

.. code-block:: php

    $userTable = $qb->leftJoin('user', 'u');
    $userTable->setNaturalJoin(true);
    $userTable->setOuterJoin(true);

WHERE Clause
------------

.. code-block:: php

    $qb->andWhere('u.active = 1');
    $qb->andWhere('u.email IS NOT NULL');


.. code-block:: mysql

    WHERE u.active = 1 AND u.email IS NOT NULL


GROUP BY Clause
---------------

.. code-block:: php

    $qb->addGroupBy('YEAR(u.created_at) ASC');
    $qb->addGroupBy('u.affiliate_id');

.. code-block:: mysql

    GROUP BY YEAR(u.country_id) ASC, u.affiliate_id

GROUP BY ... WITH ROLLUP
~~~~~~~~~~~~~~~~~~~~~~~~

For use the `WITH ROLLUP` clause, use `setGroupByWithRollUp(true)`:

.. code-block:: php

    $qb->addGroupBy('u.country_id');
    $qb->addGroupBy('u.male');
    $qb->setGroupByWithRollUp(true);

.. code-block:: mysql

    GROUP BY u.country_id, u.male WITH ROLLUP

HAVING Clause
-------------

.. code-block:: php

    $qb->addSelect('SUM(i.gross) AS gross');
    $qb->addSelect('i.transactor_id');
    $qb->from('invoice', 'i');
    $qb->addGroupBy('i.transactor_id'):
    $qb->andHaving('gross > 1000');

.. code-block:: mysql

    SELECT SUM(i.gross) AS gross, i.transactor_id
    FROM invoice AS i GROUP BY i.transactor_id HAVING gross > 1000


ORDER BY Clause
---------------

.. code-block:: php

    $qb->addOrderBy('u.last_name ASC');
    $qb->addOrderBy('u.first_name ASC');

.. code-block:: mysql

    ORDER BY u.last_name ASC, u.first_name ASC


LIMIT Clause
------------

.. code-block:: php

    $qb->setLimit(10);
    $qb->setLimit('10, 20');
    $qb->setLimit('10 OFFSET 20');

.. codeb-block:: mysql

    LIMIT 10
    LIMIT 10, 20
    LIMIT 10 OFFSET 20
