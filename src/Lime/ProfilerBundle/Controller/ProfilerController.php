<?php

namespace Lime\ProfilerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Lime\BaseBundle\Controller\BaseController;
use Lime\ProfilerBundle\Model\Xhprof\XHProf;
use Lime\ProfilerBundle\Model\Xhprof\XHProfCallGraph;

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

    public function callgraphAction()
    {
        ini_set('max_execution_time', 100);

        $xhprof     = $this->getCallGraph();
        $parameters = $_GET;
        $params     = $this->getCallGraphArray();

        foreach ($parameters as $key => $value) {
            $params[$key] = $value;
        }

        if ($params['threshold'] < 0) {
            $params['threshold'] = 0;
        }
        else if ($params['threshold'] > 1) {
            $params['threshold'] = 1;
        }

//        if (!array_key_exists($type, $xhprof_legal_image_types)) {
//            $type = $paramsRaw['type'][1]; // default image type.
//        }

        if (!empty($params['run'])) {
            $content = $xhprof->xhprof_render_image($params);
        }
        else {
            $content = $xhprof->xhprof_render_diff_image($params);
        }

        echo $content;
        die;
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
            'source' => $this->container->getParameter('lime_profiler.file_extension'),
            'all'    => 100,
        );

        return $params;
    }

    protected function getCallGraphArray()
    {
        return array(
            'run'       => '',
            'source'    => 'xhprof',
            'func'      => '',
            'type'      => 'png',
            'threshold' => 0.01,
            'critical'  => true,
            'run1'      => '',
            'run2'      => ''
        );
    }

    /**
     * Function for disabling profiler 
     */
    protected function disableProfiler()
    {
        $this->get('profiler')->disable();
    }

    /**
     *
     * @return XHProf
     */
    protected function getXhprof()
    {
        if (!isset($this->xhprof)) {
            $this->xhprof = new XHProfReport($this->getParameter('lime_profiler.location_reports'));
        }

        return $this->xhprof;
    }

    /**
     *
     * @return XHProfCallGraph
     */
    protected function getCallGraph()
    {
        if (!isset($this->callgraph)) {
            $this->callgraph = new XHProfCallGraph($this->getParameter('lime_profiler.location_reports'));
        }

        return $this->callgraph;
    }
}
