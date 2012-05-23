<?php

namespace Lime\BaseBundle\Model;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Used to parse Namespaces and retrieve classes
 *
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class BaseNamespaceParser
{
    /**
     * Class type to be retrieved by parse.
     *
     * @var string
     */
    protected $type;

    /**
     * Namespace style string of path to folder containing 
     * the requested class.
     *
     * @var string 
     */
    protected $path;

    /**
     * Actuall class to be retrieved
     *
     * @var string
     */
    protected $class;

    /**
     * Setting for throwing error if class is
     * not found.
     *
     * @var boolean 
     */
    protected $throw;

    /**
     * Construct of BaseBundleNamespaceParser class.
     *
     * @param string $path Class type to be retrieved by parse.
     * @param string $class Actuall class to be retrieved.
     * @param string $path Namespace style string of path to folder containing 
     * the requested class. (with trailing backslash)
     */
    public function getPath($class, $path = null, $type = null, $throw = true)
    {
        $this->class = $class;
        $this->path  = $path;
        $this->type  = $type;
        $this->throw = $throw;
        $index       = 1;
        $pathArray   = $this->parsePath($class);
        $namespace   = $this->getNamespace($pathArray['nsArray'], $index);
        $servicePath = $this->getServicePath($pathArray['name']);
        $classPath   = "$namespace\\$servicePath";
        
        return $this->validateClass($classPath, $index, $pathArray['nsArray'], $servicePath);
    }

    /**
     *
     * @param string $class
     * @return array
     */
    protected function parsePath($class)
    {
        $classArray = explode(':', $class);
        preg_match_all('/[A-Z][^A-Z]*/', $classArray[0], $nsArray);
        
        return array(
            'nsArray' => $nsArray[0],
            'name' => $classArray[1]
        );
    }

    /**
     *
     * @param array $nsArray
     * @param integer $index
     * @return array
     * @throws \ErrorException 
     */
    protected function getNamespace(array $nsArray, $index)
    {
        if ($index >= count($nsArray)) {
            if ($this->throw) {
                throw new InvalidArgumentException("Invalid Class: The class '$this->class.$this->type' could not be found!");
            }
            else {
                return false;
            }
        }

        $namespace = '';
        $delimiter = '\\';

        foreach ($nsArray as $key => $ns) {
            if ($key == $index) {
                $namespace .= $delimiter.$ns;
            }
            else {
                $namespace .= $ns;
            }
        }
        $index++;

        return $namespace;
    }

    /**
     * Validates the given class or offers alternatives.
     *
     * @param string $classPath
     * @param integer $index
     * @param array $nsArray
     * @param string $servicePath
     * @return string 
     */
    protected function validateClass($classPath, $index, array $nsArray, $servicePath)
    {
        while (!class_exists($classPath)) {
            $index++;
            $namespace = $this->getNamespace($nsArray, $index);

            if (false === $namespace) {
                return false;
            }

            $classPath = "$namespace\\$servicePath";
        }

        return $classPath;
    }

    /**
     * Returns the service path string.
     *
     * @param string $name
     * @return string 
     */
    protected function getServicePath($name)
    {
        if ($this->path) {
            $path = $this->path.'\\';
        }

        return $path.$name.$this->type;
    }
}
