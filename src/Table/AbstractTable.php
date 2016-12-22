<?php

namespace Phuria\UnderQuery\Table;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractTable implements TableInterface
{
    /**
     * @var BuilderInterface
     */
    private $qb;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var null|JoinMetadata
     */
    private $joinMetadata;

    /**
     * @var array $hints
     */
    private $hints = [];

    /**
     * @param BuilderInterface $qb
     */
    public function __construct(BuilderInterface $qb)
    {
        $this->qb = $qb;
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getQueryBuilder()->toReference($this);
    }

    /**
     * @inheritdoc
     */
    public function getAliasOrName()
    {
        return $this->getAlias() ?: $this->getTableName();
    }

    /**
     * @return bool
     */
    public function isJoin()
    {
        return null !== $this->joinMetadata;
    }

    /**
     * @return BuilderInterface
     */
    public function getQueryBuilder()
    {
        return $this->qb;
    }

    /**
     * @inheritdoc
     */
    public function relative(callable $callback = null)
    {
        $callback($this->getRelativeBuilder());

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRelativeBuilder()
    {
        return new RelativeQueryBuilder($this->getQueryBuilder(), $this);
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function column($name)
    {
        return $this . '.' . $name;
    }

    /**
     * @inheritdoc
     */
    public function getJoinMetadata()
    {
        return $this->joinMetadata;
    }

    /**
     * @param JoinMetadata $joinMetadata
     *
     * @return AbstractTable
     */
    public function setJoinMetadata(JoinMetadata $joinMetadata)
    {
        $this->joinMetadata = $joinMetadata;

        return $this;
    }

    /**
     * @param mixed $hint
     *
     * @return mixed
     */
    public function getHint($hint)
    {
        return $this->hints[$hint];
    }

    /**
     * @param mixed $hint
     *
     * @return bool
     */
    public function hasHint($hint)
    {
        return array_key_exists($hint, $this->hints);
    }

    /**
     * @param mixed $hint
     * @param mixed $value
     *
     * @return $this
     */
    public function setHint($hint, $value = true)
    {
        $this->hints[$hint] = $value;

        return $this;
    }

}