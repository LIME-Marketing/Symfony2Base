<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lime\UserBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Lime\UserBundle\Form\Type\ProfileFormType;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends Controller
{
    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Profile:show.html.'.$this->container->getParameter('fos_user.template.engine'), array('user' => $user));
    }

    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form    = $this->createForm(new ProfileFormType, $user->getProfile());
        $process = false;

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->container->get('fos_user.user_manager')->updateUser($user);

                $process = true;
            }

            // Reloads the user to reset its username. This is needed when the
            // username or password have been changed to avoid issues with the
            // security layer.
            $this->container->get('fos_user.user_manager')->reloadUser($user);
        }

        if ($process) {
            $this->setFlash('fos_user_success', 'profile.flash.updated');

            return new RedirectResponse($this->container->get('router')->generate('fos_user_profile_show'));
        }

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
            array(
                'form' => $form->createView(), 
                'theme' => $this->container->getParameter('fos_user.template.theme')
            )
        );
    }

    protected function setFlash($action, $value)
    {
        $this->container->get('session')->setFlash($action, $value);
    }
}
