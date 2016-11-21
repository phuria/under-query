Table Class
===========

Creating table class
--------------------

The default implementation of `TableInterface` is `UnknownTable`.
For mapping table name to class name is responsible `TableRegistry`.

First you need to crete implementation of `TableInterface`.
We highly recommend inheriting from `AbstractTable`.

.. code-block:: php

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

Then you need to add the table to configuration (see configuration section).
Now when you are referring to this table, you get instance of implemented class.

.. code-block:: php

    $qb = $qbFactory->createSelect();

    $qb->addSelect('*');

    $accountTable = $qb->from('account');
    $accountTable->onlyActive();

    echo $qb->buildSQL();

.. code-block:: mysql

    SELECT * FROM account WHERE acount.active


Relative QueryBuilder
~~~~~~~~~~~~~~~~~~~~~

In order to receive instance of `RelativeQueryBuilder`, you have to call `AbstractTable::getRelativeBuilder()`.

.. code-block:: php

    $qb->from('account')->getRelativeBuilder()
        ->addSelect('@.id');

    echo $qb->buildSQL();

.. code-block:: mysql

    SELECT account.id FROM account

Thanks to `RelativeQueryBuilder` every directive `@.` will be changed into related table's name.