<?php

namespace Lime\AdminBundle\Schema;

use Doctrine\DBAL\Connection;
use Lime\BaseBundle\Schema\BaseSchema;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class ConfigSchema extends BaseSchema
{
    protected $name;

    public function __construct()
    {
        $this->name = 'lime_admin_configs';
    }

    /**
     * Adds the configs table to the schema
     */
    protected function addConfigTable()
    {
        $table = $this->createTable($this->name);

        $table->addColumn('id', 'integer', array('unsigned' => true, 'length' => 5));
        $table->addColumn('name', 'string', array('length' => 50, 'unsigned' => true));
        $table->addColumn('index_name', 'string', array('length' => 50, 'unsigned' => true));
        $table->addColumn('value', 'string', array('length' => 150, 'unsigned' => true));

        $table->setPrimaryKey(array('id'));
    }

    public function getName()
    {
        return $this->name;
    }
}
