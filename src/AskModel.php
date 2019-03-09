<?php
namespace WScore\Ask;

use WScore\Ask\Element\Checkbox;
use WScore\Ask\Element\Radio;
use WScore\Ask\Element\Select;
use WScore\Ask\Element\Text;
use WScore\Ask\Element\TextArea;
use WScore\Ask\Interfaces\ElementInterface;

class AskModel
{
    private $data = [];

    /**
     * @param string $name
     * @param string $label
     * @return ElementInterface
     */
    public function addText($name, $label)
    {
        $element = new Text($name, $label);
        $this->data[$name] = $element;
        return $element;
    }

    /**
     * @param string $name
     * @param string $label
     * @return ElementInterface
     */
    public function addTextArea($name, $label)
    {
        $element = new TextArea($name, $label);
        $this->data[$name] = $element;
        return $element;
    }

    /**
     * @param string $name
     * @param $value
     * @param string $label
     * @return ElementInterface
     */
    public function addCheckBox($name, $value, $label = null)
    {
        $label = $label ?: $value;
        $element = new Checkbox($name, $label, $value);
        $this->data[$name] = $element;
        return $element;
    }

    /**
     * @param string $name
     * @param string $label
     * @param array $options
     * @return ElementInterface
     */
    public function addSelect($name, $label, $options = [])
    {
        $element = new Select($name, $label, $options);
        $this->data[$name] = $element;
        return $element;
    }

    /**
     * @param string $name
     * @param string $label
     * @return ElementInterface
     */
    public function addRadio($name, $label)
    {
        $element = new Radio($name, $label);
        $this->data[$name] = $element;
        return $element;
    }

    /**
     * @return Forms
     */
    public function buildForm()
    {
        return new Forms($this->data);
    }

    /**
     * @param array $input
     * @return Validation
     */
    public function buildValidator($input)
    {
        return new Validation($this->data, $input);
    }
}