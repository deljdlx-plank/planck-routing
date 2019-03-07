<?php

namespace Planck\Routing;


class RouteDescriptor implements \JsonSerializable
{

    /**
     * @var Route
     */
    protected $route;

    protected $description;
    protected $label;


    public function __construct(array $descriptor = array())
    {
        if(array_key_exists('description', $descriptor)) {
            $this->description = $descriptor['description'];
        }
        if(array_key_exists('label', $descriptor)) {
            $this->label = $descriptor['label'];
        }
    }


    public function setRoute(Route $route)
    {
        $this->route = $route;
        return $this;
    }


    public function jsonSerialize()
    {

        $builders = $this->route->getBuilders();


        $builderDescriptors = [];

        if(!empty($builders)) {

            foreach ($builders as $key => $builder) {
                $builderDescriptors[$key] = $builder;
            }
        }


        $routeValidator = $this->route->getValidator();
        if(is_string($routeValidator)) {
            $validator = array(
                'type' => 'regexp',
                'value' => $this->route->getValidator()
            );
        }
        else if($routeValidator instanceof \Closure) {
            $validator = array(
                'type' => 'closure'
            );
        }
        else if(is_bool($routeValidator)){
            $validator = array(
                'type' => 'bool',
                'value' => $routeValidator
            );
        }
        else {
            $validator = null;
        }



        $routerDescriptor = null;
        if($router = $this->route->getRouter()) {
            $routerDescriptor = array(
               'class' => get_class($router),
            );
        }
        return array(
            'label' => $this->label,
            'router' => $routerDescriptor,
            'verbs' => $this->route->getVerbs(),
            'validator' => $validator,
            'description' => $this->description,
            'builders' => $builderDescriptors,
        );
    }


}



