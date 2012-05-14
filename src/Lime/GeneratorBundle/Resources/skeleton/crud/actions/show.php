
    /**
     * Finds and displays a {{ entity }} entity.
     *
{% if 'annotation' == format %}
     * @Route("/{slug}/show", name="{{ route_name_prefix }}_show")
     * @Template()
{% endif %}
     */
    public function showAction($slug)
    {
        $entity = $this->getRepo(('{{ bundle }}:{{ entity }}')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find {{ entity }} entity.');
        }

{% if 'delete' in actions %}
        $deleteForm = $this->createDeleteForm($id);
{% endif %}

{% if 'annotation' == format %}
        return array(
            'entity'      => $entity,
{% if 'delete' in actions %}
            'delete_form' => $deleteForm->createView(),
{% endif %}
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:show.html.twig', array(
            'entity'      => $entity,
{% if 'delete' in actions %}
            'delete_form' => $deleteForm->createView(),
{%- endif %}
        ));
{% endif %}
    }
