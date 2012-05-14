<?php

namespace {{ namespace }}\Controller{{ entity_namespace ? '\\' ~ entity_namespace : '' }};

use Lime\BaseBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
{% if 'annotation' == format -%}
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
{%- endif %}

use {{ namespace }}\Entity\{{ entity }};
{% if 'new' in actions or 'edit' in actions %}
use {{ namespace }}\Form\{{ entity }}Type;
{% endif %}

/**
 * Controller for {{ entity }}.
 *
{% if 'annotation' == format %}
 * @Route("/{{ route_prefix }}")
{% endif %}
 */
class {{ entity_class }}Controller extends BaseController
{

    {%- if 'index' in actions %}
        {%- include 'actions/index.php' %}
    {%- endif %}

    {%- if 'show' in actions %}
        {%- include 'actions/show.php' %}
    {%- endif %}

    {%- if 'new' in actions %}
        {%- include 'actions/new.php' %}
        {%- include 'actions/create.php' %}
    {%- endif %}

    {%- if 'edit' in actions %}
        {%- include 'actions/edit.php' %}
        {%- include 'actions/update.php' %}
    {%- endif %}

    {%- if 'delete' in actions %}
        {%- include 'actions/delete.php' %}
    {%- endif %}

}
