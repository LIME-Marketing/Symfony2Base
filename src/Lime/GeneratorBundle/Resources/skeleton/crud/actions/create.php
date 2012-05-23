
    /**
     * Creates a new {{ entity }} entity.
     *
{% if 'annotation' == format %}
     * @Route("/create", name="{{ route_name_prefix }}_create")
     * @Method("post")
     * @Template("{{ bundle }}:{{ entity }}:new.html.twig")
{% endif %}
     */
    public function createAction(Request $request)
    {
        $entity = $this->getRepo('{{ bundle }}:{{ entity }}')->create();
        $form   = $this->createForm(new {{ entity_class }}Type(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $this->getRepo('{{ bundle }}:{{ entity }}')->save($entity);

            {% if 'show' in actions -%}
                return $this->redirect($this->generateUrl('{{ route_name_prefix }}_show', array('id' => $entity->getId())));
            {%- else -%}
                return $this->redirect($this->generateUrl('{{ route_name_prefix }}_index'));
            {%- endif %}

        }

{% if 'annotation' == format %}
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
{% endif %}
    }
