
    /**
     * Deletes a {{ entity }} entity.
     *
{% if 'annotation' == format %}
     * @Route("/{slug}/delete", name="{{ route_name_prefix }}_delete")
     * @Method("post")
{% endif %}
     */
    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($slug);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity = $this->getRepo(('{{ bundle }}:{{ entity }}')->findOneBySlug($slug);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find {{ entity }} entity.');
            }

            $this->getRepo(('{{ bundle }}:{{ entity }}')->save($entity);
        }

        return $this->redirect($this->generateUrl('{{ route_name_prefix }}'));
    }

    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder(array('slug' => $slug))
            ->add('slug', 'hidden')
            ->getForm()
        ;
    }