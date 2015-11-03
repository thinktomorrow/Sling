<?php namespace Thinktomorrow\Sling;

use Exception;
use InvalidArgumentException;

class Message {

    protected $from;
    protected $to;
    protected $cc;
    protected $bcc;
    protected $subject;
    protected $data = [];
    protected $template;
    protected $headers = [];

    public function from($email, $name)
    {
        return $this->setRecipient('from', $email, $name);
    }

    public function to($email, $name)
    {
        return $this->setRecipient('to', $email, $name);
    }

    public function cc($email, $name)
    {
        return $this->setRecipient('cc', $email, $name);
    }

    public function bcc($email, $name)
    {
        return $this->setRecipient('bcc', $email, $name);
    }

    protected function setRecipient($type, $email, $name)
    {
        if ( !filter_var($email, FILTER_VALIDATE_EMAIL) )
        {
            throw new InvalidArgumentException('Invalid email format given [' . $email . ']');
        }

        $this->{$type} = (object) ['email' => $email, 'name' => $name];

        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function data(array $data = [])
    {
        $this->data = $data;

        return $this;
    }

    public function template($template)
    {
        $this->template = $template;

        return $this;
    }

    public function headers(array $headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    public function verifyRequiredValues()
    {
        foreach(['to','from','subject','template'] as $prop)
        {
            if(empty($this->$prop)) return false;
        }

        return true;
    }

    public function reset()
    {
        $this->from = null;
        $this->to = null;
        $this->cc = null;
        $this->bcc = null;
        $this->subject = null;
        $this->data = [];
        $this->template = null;
        $this->headers = [];

        return $this;
    }

    public function __get($property)
    {
        if ( property_exists($this, $property) ) return $this->{$property};

        throw new Exception('Property [' . get_class($this) . '::$' . $property . '] does not exist');
    }

    public function __set($property, $value)
    {
        if ( property_exists($this, $property) )
        {
            throw new Exception('Cannot access protected property [' . get_class($this) . '::$' . $property . ']. Message properties are set via methods instead.');
        }

        return null;
    }

}