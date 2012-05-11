<?php

namespace Lime\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Lime\AdminBundle\Entity\Config;
use Symfony\Component\Form\FormBuilder;
use Lime\BaseBundle\Controller\BaseController;
use Lime\AdminBundle\Form\ConfigForm;
use Lime\BaseBundle\Model\EntityInterface;

class ConfigController extends BaseController
{

    public function indexAction()
    {
        $configRepo = $this->getConfigRepo();
        $configs    = $configRepo->findAll();
        $form       = $this->createFormBuilder()->getForm();
        $request    = $this->getRequest();
        $message    = null;

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            $value = $request->get('value');
            $name  = $request->get('name');

            if ($form->isValid()) {
                $config = $configRepo->findOneByName($name);
                $config->setValue($value);
                $configRepo->save($config);

                $message = 'Settings saved successfully.';
            }
        }

        return $this->render('LimeAdminBundle:Config:index.html.twig', array(
            'configs' => $configs,
            'form'    => $form->createView(),
            'message' => $message,
        ));
    }

    protected function getConfigRepo()
    {
        return $this->getRepo('LimeAdminBundle:Config');
    }
}
