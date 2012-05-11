<?php

namespace Lime\AdminBundle\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;
use Lime\BaseBundle\Manager\BaseManager;
use Lime\AdminBundle\Schema\ConfigSchema;
use Lime\AdminBundle\Constant\ConfigConstants;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class ConfigService
{
    protected $repo;

    public function __construct(Container $container)
    {
        $this->repo = $container->get('base_repository_factory')->get('LimeAdminBundle:Config');
    }

    /**
        *
        * @param Connection $connection
        * @return string|boolean 
        */
    public function commandInit(Connection $connection)
    {
        $schema = new ConfigSchema(array(), $connection);
        $schemaManager = $connection->getSchemaManager();

        if (!$schemaManager->tablesExist($schema->getName())) {
            try {
                $schema->addToSchema($schemaManager->createSchema());
            }
            catch (SchemaException $e) {
                $error = "Aborting: " . $e->getMessage();
                return $error;
            }

            foreach ($schema->toSql($connection->getDatabasePlatform()) as $sql) {
                $connection->exec($sql);
            }
        }

        return true;
    }

    /**
        *
        * @param ConfigConstants $configConstants 
        */
    public function populateDefaults(ConfigConstants $configConstants)
    {
        $configs = $configConstants->getConfigs();

        foreach ($configs as $config) {

            $configEntity = $this->repo->findOneBy(array('indexName' => $config['index_name']));

            if (!$configEntity) {
                $entity = $this->repo->create();

                $entity->setName($config['name']);
                $entity->setIndexName($config['index_name']);
                $entity->setDescription($config['description']);
                $entity->setValue($config['value']);

                $this->repo->save($entity);
            }
            else {
                $configEntity->setName($config['name']);
                $configEntity->setIndexName($config['index_name']);
                $configEntity->setDescription($config['description']);
                $configEntity->setValue($config['value']);

                $this->repo->save($configEntity);
            }
        }
    }

    /**
        *
        * @return array configArray 
        */
    public function getConfigs()
    {
        $configs     = $this->repo->findAll();
        $configArray = array();

        foreach ($configs as $config) {
            $configArray[$config->getIndexName()] = $config->getValue();
        }

        return $configArray;
    }
    
    public function getValue($config_index)
    {
        $config = $this->repo->findOneBy(array('indexName' => $config_index));

        if ($config) {
            return $config->getValue();
        }

        return false;
    }
}