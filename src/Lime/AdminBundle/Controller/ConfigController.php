<?php

namespace Lime\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Lime\AdminBundle\Entity\Config;
use Lime\BaseBundle\Controller\BaseController;
use Lime\AdminBundle\Form\ConfigForm;
use Lime\BaseBundle\Model\EntityInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 * @Route("/site-configuration")
 */
class ConfigController extends BaseController
{

    /**
     *
     * @Route("/", name="lime.admin.config.index")'
     * @Template
     */
    public function indexAction(Request $request)
    {
        $configRepo = $this->getConfigRepo();
        $configs    = $configRepo->findAll();
        $form       = $this->getConfigForm();
        $token      = $this->generateCsrf('site-configs');
        $request    = $this->getRequest();
        $message    = null;

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            $data = $form->getData();

            if ($form->isValid()) {
                $config = $configRepo->findOneByName($data['name']);

                $config->setValue($data['value']);
                $configRepo->save($config);

                $message = 'Settings saved successfully.';
            }
        }

        return $this->render('LimeAdminBundle:Config:index.html.twig', array(
            'configs' => $configs,
            'form'    => $form->createView(),
            'message' => $message,
            'token'   => $token,
        ));
    }

    /**
     *
     * @return \Lime\BaseBundle\Repository\BaseRepository  
     */
    protected function getConfigRepo()
    {
        return $this->getRepo('LimeAdminBundle:Config');
    }

    /**
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function getConfigForm()
    {
        $form = $this->createFormBuilder(null, array(
            'intention' => 'site-configs',
        ));

        $form->add('value')
             ->add('name')
        ;

        return $form->getForm();
    }
}
