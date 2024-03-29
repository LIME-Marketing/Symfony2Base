
    /**
     * Lists all {{ entity }} entities.
     *
{% if 'annotation' == format %}
     * @Route("/", name="{{ route_name_prefix }}_index")
     * @Template()
{% endif %}
     */
    public function indexAction()
    {
        $entities = $this->getRepo('{{ bundle }}:{{ entity }}')->findAll();

{% if 'annotation' == format %}
        return array(
            'entities' => $entities,
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:index.html.twig', array(
            'entities' => $entities,
        ));
{% endif %}
    }
