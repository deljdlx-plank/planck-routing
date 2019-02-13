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



        return array(
            'label' => $this->label,
            'description' => $this->description,
            'builders' => $builderDescriptors,
        );
    }


}



