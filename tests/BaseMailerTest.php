<?php

class BaseMailerTest extends TestCase {

    private $laravelMailer;
    private $message;
    private $log;
    private $basemailer;

    public function setUp()
    {
        parent::setUp();

        $this->laravelMailer = Mockery::mock('Illuminate\Mail\Mailer');
        $this->message = new Thinktomorrow\Sling\Message;
        $this->log = Mockery::mock('Illuminate\Log\Logger');

        $this->basemailer = new Thinktomorrow\Sling\BaseMailer($this->laravelMailer,$this->message,$this->log);
    }

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    public function test_it_can_send_mail()
    {
        $this->laravelMailer->shouldReceive('send')->once()->andReturn('foobar');
        $this->log->shouldReceive('info')->once()->andReturn('written');

        // Required Message properties
        $this->message->to('foo@example.com','bar');
        $this->message->from('foo3@example.com','bar3');
        $this->message->data(['foo' => 'bar']);
        $this->message->subject('onderwerp');
        $this->message->template('view');

        $result = $this->basemailer->send();

        $this->assertEquals('foobar',$result);
    }

    public function test_it_can_set_message_values()
    {
        $this->laravelMailer->shouldReceive('send')->once()->andReturn('foobar');
        $this->log->shouldReceive('info')->once()->andReturn('written');

        // Required Message properties
        $this->basemailer->to('foo@example.com','bar');
        $this->basemailer->from('foo3@example.com','bar3');
        $this->basemailer->data(['foo' => 'bar']);
        $this->basemailer->subject('onderwerp');
        $this->basemailer->template('view');

        $result = $this->basemailer->send();

        $this->assertEquals('foobar',$result);
        $this->assertEquals('view',$this->message->template);
    }

    public function test_it_sends_if_all_required_fields_are_set()
    {
        $this->setExpectedException('Thinktomorrow\Sling\Exceptions\MissingValuesException');

        $this->laravelMailer->shouldReceive('send')->never();
        $this->log->shouldReceive('info')->never();

        // Required Message properties: template is left out!
        $this->message->to('foo@example.com','bar');
        $this->message->from('foo3@example.com','bar3');
        $this->message->data(['foo' => 'bar']);
        $this->message->subject('onderwerp');

        $this->basemailer->send();
    }
}