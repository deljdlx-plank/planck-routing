<?php

namespace Planck\Routing;


use Planck\Traits\HasLocalResource;
use Planck\Traits\IsApplicationObject;

class Route extends \Phi\Routing\Route
{

    use HasLocalResource;
    use IsApplicationObject;


    protected $descriptor;


    public function __construct($verbs = 'get', $validator = false, $callback = null, array $headers = array(), $name = null)
    {
        parent::__construct($verbs, $validator, $callback, $headers, $name);

        $this->afterHook = function() {
            $redirection = $this->request->get('redirect');
           if($redirection && !$this->request->data('no-redirection')) {
               $this->redirect($redirection);
           }
        };

    }


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
