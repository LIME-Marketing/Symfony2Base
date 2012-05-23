
    /**
     * Edits an existing {{ entity }} entity.
     *
{% if 'annotation' == format %}
     * @Route("/{slug}/update", name="{{ route_name_prefix }}_update")
     * @Method("post")
     * @Template("{{ bundle }}:{{ entity }}:edit.html.twig")
{% endif %}
     */
    public function updateAction(Request $request, $slug)
    {
        $entity = $this->getRepo('{{ bundle }}:{{ entity }}')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find {{ entity }} entity.');
        }

        $editForm   = $this->createForm(new {{ entity_class }}Type(), $entity);
        $deleteForm = $this->createDeleteForm($slug);

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $this->getRepo('{{ bundle }}:{{ entity }}')->save($entity);

            return $this->redirect($this->generateUrl('{{ route_name_prefix }}_edit', array('slug' => $slug)));
        }

{% if 'annotation' == format %}
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
{% endif %}
    }
