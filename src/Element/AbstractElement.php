<?php
namespace WScore\Ask\Element;

use WScore\Ask\Interfaces\ElementInterface;

abstract class AbstractElement implements ElementInterface
{
    protected $name;
    protected $label;
    protected $required = true;
    protected $options = [];
    protected $value = null;
    protected $message = '';

    /**
     * @return string
     */
    public function label()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function value()
    {
        return $this->value;
    }

    public function hasOptions()
    {
        return count($this->options) > 0;
    }

    /**
     * @return self[]
     */
    public function options()
    {
        $options = [];
        foreach($this->options as $value => $label) {
            $option = clone($this);
            $option->value = $value;
            $option->label = $label;
            $options[] = $option;
        }
        return $options;
    }

    /**
     * @param bool $required
     * @return $this|ElementInterface
     */
    public function required($required = true)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param string $value
     * @param string|null $name
     * @return $this|ElementInterface
     */
    public function addOption($value, $name = null)
    {
        $this->options[$value] = $name ?: $value;
        return $this;
    }

    /**
     * @param string $message
     * @return void|ElementInterface
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}