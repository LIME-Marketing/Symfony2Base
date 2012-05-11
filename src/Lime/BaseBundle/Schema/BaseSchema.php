<?php

namespace Lime\BaseBundle\Schema;

use Doctrine\DBAL\Schema\Schema as BaseSymfonySchema;
use Doctrine\DBAL\Connection;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class BaseSchema extends BaseSymfonySchema
{
    protected $options;

    /**
     * Constructor
     *
     * @param array $options the names for tables
     * @param Connection $connection
     */
    public function __construct(array $options, Connection $connection = null)
    {
        $schemaConfig = null === $connection ? null : $connection->getSchemaManager()->createSchemaConfig();

        parent::__construct(array(), array(), $schemaConfig);

        $this->options = $options;
        $this->addActionTable();
    }

    /**
     * Merges generated schema with the given schema.
     *
     * @param BaseSchema $schema
     */
    public function addToSchema(BaseSymfonySchema $schema)
    {
        foreach ($this->getTables() as $table) {
            $schema->_addTable($table);
        }

        foreach ($this->getSequences() as $sequence) {
            $schema->_addSequence($sequence);
        }
    }
}