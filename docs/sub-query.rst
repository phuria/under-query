Sub Query
=========

To use a sub query like table, pass it as argument (instead of the name of the table).
You will get in return an instance of `SubQueryTable`
that you can use like normal table (eg. you can set alias).

.. code-block:: php

    $qb = $phuriaSQL->createSelect();
    $subQb->addSelect('MAX(pricelist.price) AS price');
    $subQb->from('pricelist');
    $subQb->addGroupBy('pricelist.owner_id');

    $qb = $phuriaSQL->createSelect();
    $subTable = $qb->from($subQb, 'src');
    $qb->addSelect("AVG({$subTable->column('price')})");

    echo $qb->buildSQL();

.. code-block:: mysql

    SELECT AVG(src.price) FROM (SELECT MAX(pricelist.price) AS price
    FROM pricelist GROUP BY pricelist.owner_id) AS src


If you want to use sub query in a different context
then you must use object to string reference converter.

.. code-block:: php

    $qb = $phuriaSQL->createSelect();
    $subQb->addSelect('DISTINCT user.affiliate_id');
    $subQb->form('user');

    $qb = $phuriaSQL->createSelect();
    $qb->addSelect("10 = ({$qb->objectToString($subQb)})");

    echo $qb->buildSQL();

.. code-block:: mysql

    SELECT 10 IN (SELECT DISTINCT user.affiliate_id FROM user)

At the time of building query `ReferenceParser` will be known what to do with it.
