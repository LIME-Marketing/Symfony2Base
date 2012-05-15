<?php

namespace Lime\ProfilerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \XHProfRuns_Default;
use Lime\ProfilerBundle\Model\Xhprof\xhprof_lib\display\xhprof;
use Lime\BaseBundle\Controller\BaseController;

/**
 * Description of ProfilerController
 *
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class ProfilerController extends BaseController
{
    /**
     *
     * @var xhprof 
     */
    protected $exec;

    /**
     * Class constructor. 
     */
    public function __construct()
    {
        $this->exec = new xhprof();
    }

    /**
     *
     * @param Request $request
     * @return Response 
     */
    public function indexAction(Request $request)
    {
        $this->disableProfiler();

        $xhprof     = new XHProfRuns_Default();
        $parameters = $_GET;
        $params     = $this->getParameterArray();

        foreach ($parameters as $key => $value) {
            $params[$key] = $value;
        }

        ob_start();
        $this->exec->displayXHProfReport($xhprof, $params);
        $output = ob_get_contents();
        ob_end_clean();

        return $this->render('LimeProfilerBundle:Collector:index.html.twig', array(
            'url'    => $request->server->get('REQUEST_URI'),
            'params' => $params,
            'output' => $output,
        ));
    }

    public function callgraphAction()
    {
        
    }

    /**
     * Function for retrieving parameters
     *
     * @return array
     */
    protected function getParameterArray()
    {
        $params = array(
            'run'    => '',
            'wts'    => '',
            'symbol' => '',
            'sort'   => 'wt',
            'run1'   => '',
            'run2'   => '',
            'source' => 'Symfony',
            'all'    => 0,
        );

        return $params;
    }

    /**
     * Function for disabling profiler 
     */
    protected function disableProfiler()
    {
        $this->get('profiler')->disable();
    }
}
