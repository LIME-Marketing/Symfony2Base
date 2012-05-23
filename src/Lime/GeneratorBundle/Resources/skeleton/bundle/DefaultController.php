<?php

namespace {{ namespace }}\Controller;

use Lime\BaseBundle\Controller\BaseController;
{% if 'annotation' == format -%}
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
{% endif %}

class DefaultController extends BaseController
{
    {% if 'annotation' == format -%}
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    {% endif -%}
    public function indexAction($name)
    {
        {% if 'annotation' != format -%}
        return $this->render('{{ bundle }}:Default:index.html.twig', array('name' => $name));
        {%- else -%}
        return array('name' => $name);
        {%- endif %}

    }
}
