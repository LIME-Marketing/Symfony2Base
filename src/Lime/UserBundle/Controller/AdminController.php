<?php

namespace Lime\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * 
     * @Route("/", name="lime.user.admin.index")
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
           'users' => $users,
           'token' => $token,
        ));
    }

    /**
     * URL for processing user promotions.
     *
     * @param Request $request
     * @return Response
     * 
     * @Route("/promote", name="lime.user.admin.promote")
     */
    public function promoteAction(Request $request)
    {
        $form  = $this->getRoleForm();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $user = $this->getUserRepo()->findOneBy(array(
                    'email' => $data['user'],
            ));

            $user->addRole('ROLE_ADMIN');
            $this->getUserRepo()->save($user);
        }

        return $this->redirect($this->generateUrl('lime.user.admin.index'));
    }

    /**
     * URL for processing user demotions.
     *
     * @param Request $request
     * @return Response
     * 
     * @Route("/demote", name="lime.user.admin.demote")
     */
    public function demoteAction(Request $request)
    {
        $form  = $this->getRoleForm();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $user = $this->getUserRepo()->findOneBy(array(
                    'email' => $data['user'],
            ));

            $user->removeRole('ROLE_ADMIN');
            $user->removeRole('ROLE_SUPER_ADMIN');
            $this->getUserRepo()->save($user);
        }

        return $this->redirect($this->generateUrl('lime.user.admin.index'));
    }

    /**
     *
     * @return \Lime\BaseBundle\Repository\BaseRepository  
     */
    protected function getUserRepo()
    {
        return $this->getRepo('LimeUserBundle:User');
    }

    /**
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function getRoleForm()
    {
        $form = $this->createFormBuilder(null, 
            array(
                'intention' => 'user_action',
            )
        )->add('user');

        return $form->getForm();
    }
}
