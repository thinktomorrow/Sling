<?php

class A_MessageTest extends TestCase {

    private $message;

    public function setUp()
    {
        parent::setUp();

        $this->message = new Thinktomorrow\Sling\Message;
    }

    public function test_it_cannot_set_a_property_directly()
    {
        $this->setExpectedException('Exception');

        $this->message->to = 'foo';
        $this->assertNull($this->message->to);
    }

    public function test_it_sets_a_property_via_method()
    {
        $this->message->to('foo@example.com','bar');
        $this->assertEquals('foo@example.com',$this->message->to->email);
        $this->assertEquals('bar',$this->message->to->name);
    }

    public function test_it_checks_for_valid_recipient_email()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->message->to('foo','bar');
    }

    public function test_it_forces_data_as_array()
    {
        $this->setExpectedException('TypeError');

        $this->message->data('foo');
    }

    public function test_it_forces_headers_as_array()
    {
        $this->setExpectedException('TypeError');

        $this->message->headers('foo');
    }

    public function test_it_does_not_allow_to_retrieve_unknown_property()
    {
        $this->setExpectedException('Exception');

        $this->message->foobar;
    }

    public function test_it_sets_all_properties()
    {
        $this->message->to('foo@example.com','bar');
        $this->message->cc('foo1@example.com','bar1');
        $this->message->bcc('foo2@example.com','bar2');
        $this->message->from('foo3@example.com','bar3');
        $this->message->data(['foo' => 'bar']);
        $this->message->subject('onderwerp');
        $this->message->template('view');
        $this->message->headers(['foo' => 'baz']);

        $this->assertEquals('foo@example.com',$this->message->to->email);
        $this->assertEquals('bar',$this->message->to->name);
        $this->assertEquals('foo1@example.com',$this->message->cc->email);
        $this->assertEquals('bar1',$this->message->cc->name);
        $this->assertEquals('foo2@example.com',$this->message->bcc->email);
        $this->assertEquals('bar2',$this->message->bcc->name);
        $this->assertEquals('foo3@example.com',$this->message->from->email);
        $this->assertEquals('bar3',$this->message->from->name);
        $this->assertEquals('onderwerp',$this->message->subject);
        $this->assertEquals(['foo' => 'bar'],$this->message->data);
        $this->assertEquals('view',$this->message->template);
        $this->assertEquals(['foo' => 'baz'],$this->message->headers);

    }

    public function test_it_can_reset_itself()
    {
        $this->message->to('foo@example.com','bar');

        $this->message->reset();

        $this->assertNull($this->message->to);
    }

    public function test_it_can_check_if_required_values_are_set()
    {
        $this->message->to('foo@example.com','bar');
        $this->message->from('foo3@example.com','bar3');
        $this->message->subject('onderwerp');
        $this->message->template('view');

        $this->assertTrue($this->message->verifyRequiredValues());

        // Nothing set at all...
        $this->message->reset();
        $this->assertFalse($this->message->verifyRequiredValues());

        // Template is left out...
        $this->message->reset();
        $this->message->to('foo@example.com','bar');
        $this->message->from('foo3@example.com','bar3');
        $this->message->subject('onderwerp');

        $this->assertFalse($this->message->verifyRequiredValues());
    }

}