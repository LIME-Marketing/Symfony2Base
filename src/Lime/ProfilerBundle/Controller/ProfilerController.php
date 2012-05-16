<?php

namespace Lime\ProfilerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Lime\BaseBundle\Controller\BaseController;
use Lime\ProfilerBundle\Model\Xhprof\XHProf;

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
     *
     * @param Request $request
     * @return Response 
     */
    public function indexAction(Request $request)
    {
        $this->disableProfiler();

        $exec       = new XHProf($this->getParameter('lime_profiler.location_reports'));
        $parameters = $_GET;
        $params     = $this->getParameterArray();

        foreach ($parameters as $key => $value) {
            $params[$key] = $value;
        }

        ob_start();
        $exec->displayXHProfReport($params);
        $output = ob_get_contents();
        ob_end_clean();

        return $this->render('LimeProfilerBundle:Collector:index.html.twig', array(
            'url'    => $request->server->get('REQUEST_URI'),
            'params' => $params,
            'output' => $output,
        ));
    }

//    public function callgraphAction()
//    {
//        
//    }

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
