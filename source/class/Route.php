<?php

namespace Planck\Routing;


use Planck\Traits\HasLocalResource;
use Planck\Traits\IsApplicationObject;

class Route extends \Phi\Routing\Route
{

    use HasLocalResource;
    use IsApplicationObject;


    protected $descriptor;

    public function setDescriptor(RouteDescriptor $descriptor)
    {
        $this->descriptor = $descriptor;
        $this->descriptor->setRoute($this);
        return $this;
    }


    public function getDescriptor()
    {
        return $this->descriptor;
    }

    public function hasDescriptor()
    {
        if($this->descriptor) {
            return true;
        }

        return false;
    }


}
