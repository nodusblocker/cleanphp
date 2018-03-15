<?php

namespace NodusBlocker\CleanPhp\Accessor;

abstract class ParameterBag
{

    protected function __construct($parameters = [])
    {
        $this->parameters = is_array($parameters) ? $parameters : array();
        $this->accessor   = new ArrayAccessor();
    }

    public function get($key, $default = null)
    {
        return $this->accessor->get($this->parameters, $key, $default);
    }

    public function set($key, $value)
    {
        return $this->accessor->set($this->parameters, $key, $value);
    }

    public function has($key)
    {
        return $this->accessor->has($this->parameters, $key);
    }

    public function remove($key)
    {
        return $this->accessor->remove($this->parameters, $key);
    }

    public function replace($array)
    {
        return $this->accessor->replace($this->parameters, $array);
    }

    public function update($array)
    {
        return $this->accessor->update($this->parameters, $array);
    }

    public function all()
    {
        return is_array($this->parameters) ? $this->parameters : array();
    }
}
