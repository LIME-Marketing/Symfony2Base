<?php

namespace Lime\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Lime\BaseBundle\Controller\BaseController;

/**
 * Class controller for admin functions involving user entities
 * 
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class AdminController extends BaseController
{

    /**
     * Index page for users. Displays a list of all users registered for the site.
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $users      = array();
        $searchterm = $request->get('searchterm');
        $token      = $this->generateCsrf('user_action');

        if (isset($searchterm)) {
            $results = $this->getUserRepo()->weightedSearch($searchterm, array('username' => '5'));

            foreach ($results as $result) {
                $users[] = $result[0];
            }
        }
        else {
            $users = $this->getUserRepo()->findAll();
        }

        return $this->render('LimeUserBundle:Admin:index.html.twig', array(
           'user' => $user,
           'token'     => $token,
        ));
    }

    /**
     * URL for processing user promotions.
     *
     * @param Request $request
     * @return Response 
     */
    public function promoteAction(Request $request)
    {
        $token = $this->generateCsrf('user_action');
        $form  = $request->get('form');

        if ($form['_token'] === $token) {
            $user = $this->getUserRepo()->findOneByUsername($form['user']);

            $user->addRole('ROLE_ADMIN');
            $this->getUserRepo()->save($user);
        }

        return $this->redirect($this->generateUrl('lime_user_admin_index'));
    }

    /**
     * URL for processing user demotions.
     *
     * @param Request $request
     * @return Response 
     */
    public function demoteAction(Request $request)
    {
        $token = $this->generateCsrf('user_action');
        $form  = $request->get('form');

        if ($form['_token'] === $token) {
            $user = $this->getUserRepo()->findOneByUsername($form['user']);

            $user->removeRole('ROLE_ADMIN');
            $user->removeRole('ROLE_SUPER_ADMIN');
            $this->getUserRepo()->save($user);
        }

        return $this->redirect($this->generateUrl('lime_user_admin_index'));
    }

    protected function getUserRepo()
    {
        return $this->getRepo('LimeUserBundle:User');
    }
    
}
