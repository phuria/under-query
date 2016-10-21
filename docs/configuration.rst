Configuration
-------------

To resolve dependency in this library
has been used `Container` from `pimple/pimple` package.

To create `Container` with default configuration, use `ContainerFactory`:

.. code-block:: php

    use Phuria\SQLBuilder\DependencyInjection\ContainerFactory;

    $containerFactory = ContainerFactory();
    $container = $containerFactory->create();

Now you can make changes. At the end do not forget to pass the `Container` instance
to `QueryBuilder`:

.. code-block:: php

    use Phuria\SQLBuilder\PhuriaSQLBuilder;

    $phuriaSQL = new PhuriaSQLBuilder($container);

Registering custom table class
------------------------------

.. code-block:: php

    $registry = $container['phuria.sql_builder.table_registry'];
    $registry->registerTable($tableClass, $tableName)

Argument `$tableClass` must be fully-qualified class name,
`$tableName` must be full name of database table.
