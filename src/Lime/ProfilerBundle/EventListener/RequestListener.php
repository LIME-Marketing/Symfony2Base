<?php

namespace Lime\ProfilerBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Lime\ProfilerBundle\DataCollector\XhprofCollector;

/**
 * RequestListener.
 *
 * The handle method must be connected to the core.request event.
 *
 * @author Jonas Wouters <hello@jonaswouters.be>
 */
class RequestListener
{
    protected $collector;

    public function __construct(XhprofCollector $collector)
    {
        $this->collector = $collector;
    }

    public function onCoreRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType() &&
            $event->getRequest()->server->get('PHP_SELF') !== '/app_dev.php/_memory_profiler/') {

            $this->collector->startProfiling();
        }
    }

    public function onCoreResponse(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType() &&
            $event->getRequest()->server->get('PHP_SELF') !== '/app_dev.php/_memory_profiler/') {

            $this->collector->stopProfiling();
        }
    }
}
