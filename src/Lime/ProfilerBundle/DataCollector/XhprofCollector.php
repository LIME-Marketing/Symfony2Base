<?php

namespace Lime\ProfilerBundle\DataCollector;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Lime\ProfilerBundle\Model\Xhprof\XHProf;

/**
 * XhprofDataCollector.
 *
 * @author Jonas Wouters <hello@jonaswouters.be>
 */
class XhprofCollector extends DataCollector
{
    protected $container;
    protected $logger;
    protected $runId;
    protected $profiling = false;
    protected $xhprof;

    public function __construct(ContainerInterface $container, LoggerInterface $logger = null)
    {
        $this->container = $container;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if ($this->functionCheck()) {

            if (!$this->runId) {
                $this->stopProfiling();
            }

            $this->data = array(
                'xhprof' => $this->runId,
            );
        }
    }

    public function startProfiling()
    {
        if ($this->functionCheck()) {

            if (PHP_SAPI == 'cli') {
                $_SERVER['REMOTE_ADDR'] = null;
                $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
            }

            $this->profiling = true;
            xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

            if ($this->logger) {
                $this->logger->debug('Enabled XHProf');
            }
        }
    }

    public function stopProfiling()
    {
        
        if ($this->functionCheck()) {

            global $_xhprof;

            if (!$this->profiling) {
                return;
            }

            $this->profiling = false;

//            require_once $this->container->getParameter('lime_profiler.location_config');
//            require_once $this->container->getParameter('lime_profiler.location_lib');
//            require_once $this->container->getParameter('lime_profiler.location_runs');

            $xhprof_data = xhprof_disable();

            if ($this->logger) {
                $this->logger->debug('Disabled XHProf');
            }

            $uri = $this->container->get('request')->server->get('REQUEST_URI');
            $uri = str_replace('/', '_', $uri);
            $uri = str_replace('_app_dev.php', 'app_dev.php', $uri);

            $xhprof_runs = new XHProf($this->container->getParameter('lime_profiler.location_reports'));
            $this->runId = $xhprof_runs->save_run($xhprof_data, "Symfony", $uri);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        if ($this->functionCheck()) {
            return 'xhprof';
        }
    }

    /**
     * Gets the run id.
     *
     * @return integer The run id
     */
    public function getXhprof()
    {
        if ($this->functionCheck()) {
            return $this->data['xhprof'];
        }
    }

    /**
     * Gets the XHProf url.
     *
     * @return integer The XHProf url
     */
    public function getXhprofUrl()
    {
        if ($this->functionCheck()) {
            return $_SERVER['SCRIPT_NAME'] . '/_memory_profiler/?run=' . $this->data['xhprof'] . '&source=Symfony';
        }
    }

    protected function functionCheck()
    {
        return function_exists('xhprof_enable');
    }
}
