<?php

namespace Lime\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\EventDispatcher\Event;

/**
 * Base Controller class that adds additional functionality and convenience to extending controllers.
 * 
 * @author Michael Shattuck <ms2474@gmail.com>
 */
abstract class BaseController extends Controller
{

    /**
     * Returns a repository that is auto-generated by the base repository factory.
     *
     * @param type $repository
     * @return type Lime\BaseBundle\Repository\BaseRepository
     */
    public function getRepo($repository)
    {
        return $this->container->get('base_repository_factory')->get($repository);
    }

    /**
     * Returns a generated service class.
     *
     * @param string $class
     * @return Service 
     */
    public function getService($class)
    {
        return $this->container->get('base_service_factory')->get($class);
    }

    /**
     * Returns the base repository factory.
     *
     * @return type Lime\BaseBundle\Factory\BaseRepoFactory
     */
    public function getBaseRepo()
    {
        return $this->container->get('base_repository_factory');
    }

    /**
     * Checks users access for a given role.
     *
     * @param type $role
     * @param type $throwError
     * @return type boolean
     * @throws AccessDeniedException 
     */
    public function checkAccess($role, $throwError = false)
    {
        $access = $this->container->get('security.context')->isGranted($role);

        if (!$access && $throwError) {
            throw new AccessDeniedException();
        }

        return $access;
    }

    /**
     * Set flash message. (A message the is stored in the session for one request)
     *
     * @param type $action
     * @param type $value 
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->setFlash($action, $value);
    }

    /**
     * Returns the given parameter from the service container.
     *
     * @param type $parameter
     * @return string|array|boolean|integer|float config parameter
     */
    public function getParameter($parameter)
    {
        return $this->container->getParameter($parameter);
    }

    /**
     * Convenience function for retreiving the event_dispatcher service and using it to send an event.
     *
     * @param type $name
     * @param Event $event 
     */
    public function sendEvent($name, Event $event)
    {
        $this->container->get('event_dispatcher')->dispatch($name, $event);
    }

    /**
     * Convenience function for generating a csrf token for a given intention.
     *
     * @param type $intention
     * @return string CSRF Token
     */
    public function generateCsrf($intention)
    {
        return $this->container->get('form.csrf_provider')->generateCsrfToken($intention);
    }

    /**
     * Function to send an email using swiftmailer.
     *
     * @param type $to
     * @param type $from
     * @param type $subject
     * @param type $body
     * @param type $contentType
     * @param type $charset
     * @return results of sendmail 
     */
    public function getMailer($to, $from, $subject = null, $body = null, $contentType = null, $charset = null)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($body)
                ->setCharset($charset)
        ;
        if ($contentType) {
            $message->setContentType($contentType);
        }

        return $this->container->get('mailer')->send($message);
    }

    /**
     * Convenience function that returns the event dispatcher
     *
     * @return type Symfony\Component\EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->get('event_dispatcher');
    }

    /**
     * Sets a key/value cookie.
     *
     * @param wild $key
     * @param wild $value
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setCookie($key, $value, Response $response = null)
    {
        if (!$response) {
           $response = new Response();
        }

       $response->headers->setCookie(new Cookie($key, $value));

       return $response;
    }
}