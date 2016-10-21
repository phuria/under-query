Examples
========

Simple SELECT
-------------

.. code-block:: php

    $qb = $qbFactory->createSelect();

    $qb->addSelect('u.name', 'c.phone_number');
    $qb->from('user', 'u');
    $qb->leftJoin('contact', 'c', 'u.id = c.user_id');

    echo $qb->buildSQL();