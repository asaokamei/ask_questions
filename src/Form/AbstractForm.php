<?php
namespace WScore\Ask\Form;

use WScore\Ask\Interfaces\ElementInterface;
use WScore\Ask\Interfaces\FormInterface;

abstract class AbstractForm implements FormInterface
{
    /**
     * @var ElementInterface
     */
    protected $element;

    /**
     * @var string
     */
    protected $label_class = '';

    /**
     * @var string
     */
    protected $form_class = '';

    /**
     * @var string
     */
    protected $style;

    /**
     * @var bool
     */
    protected $isOptionElement = false;

    /**
     * @var int
     */
    protected $optionIndex = 0;

    /**
     * Form constructor.
     * @param ElementInterface $element
     */
    public function __construct($element)
    {
        $this->element = $element;
    }

    /**
     * @return ElementInterface
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @return bool
     */
    public function hasOptions()
    {
        return $this->element->hasOptions();
    }

    /**
     * @return self[]
     */
    public function getOptions()
    {
        $elements = [];
        $index = 0;
        foreach ($this->element->options() as $option) {
            $element = clone $this;
            $element->element = $option;
            $element->isOptionElement = true;
            $element->optionIndex = $index;
            $elements[$index] = $element;
            $index++;
        }
        return $elements;
    }

    /**
     * @param string $class
     * @return $this|FormInterface
     */
    public function setLabelClass($class)
    {
        $this->label_class = $class;
        return $this;
    }

    /**
     * @param string $class
     * @return $this|FormInterface
     */
    public function setFormClass($class)
    {
        $this->form_class = $class;
        return $this;
    }

    /**
     * @param string $class
     * @return $this|FormInterface
     */
    public function addFormClass($class)
    {
        $this->form_class .= ' ' . $class;
        return $this;
    }

    /**
     * @param string $style
     * @return self
     */
    public function setFormStyle($style)
    {
        $this->style = $style;
        return $this;
    }

    protected function makeAttr($name, $value)
    {
        $value = htmlspecialchars($value, ENT_QUOTES);
        return "{$name}=\"{$value}\"";
    }

    protected function makeClass($class = '')
    {
        if ($this->element->isRequired()) {
            $class .= ' required';
        }
        $class = trim($class);
        return $this->makeAttr('class', $class);
    }

    protected function makeId()
    {
        $name = trim($this->element->name());
        if ($value = $this->element->value()) {
            $name .= '_' . trim($value);
        }
        $name = str_replace(['[',']'], '_', $name);
        return $name;
    }

    protected function makeValue()
    {
        $value = trim($this->element->value());
        if (!$value) {
            return '';
        }
        $value = str_replace(['[',']'], '_', $value);
        return $this->makeAttr('value', $value);
    }

    /**
     * @return string
     */
    public function makeLabel()
    {
        $class = $this->makeClass($this->label_class);
        $for   = $this->makeAttr('for', $this->makeId());
        return "<label {$for} {$class}>{$this->element->label()}</label>";
    }

    protected function makeInputType($type)
    {
        $class = $this->makeClass($this->form_class);
        $name  = $this->makeAttr('name', $this->element->name());
        $required = $this->element->isRequired()
            ? 'required'
            : '';
        $id = $this->makeAttr('id', $this->makeId());
        $holder = $this->element->placeholder();
        $holder = $holder ? $this->makeAttr('placeholder', $holder) : '';
        $value = $this->element->value();
        $value = $value ? $this->makeAttr('value', $value): '';
        $style = $this->style ? "style=\"{$this->style}\"": '';

        return "<input type='{$type}' {$name} {$id} {$required} {$class} {$holder} {$value} {$style}>";
    }
}