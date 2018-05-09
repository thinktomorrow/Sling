<?php namespace Thinktomorrow\Sling;

use BadMethodCallException;
use Thinktomorrow\Sling\Exceptions\MissingValuesException;
use Illuminate\Mail\Mailer as LaravelMailer;
use Illuminate\Log\Logger as Log;

class BaseMailer implements Mailer {

    /**
     * Enable logging
     *
     * @var bool
     */
    public $enable_log = true;
    protected $laravelMailer;
    protected $log;
    protected $message;

    public function __construct(LaravelMailer $laravelMailer, Message $message, Log $log)
    {
        $this->laravelMailer = $laravelMailer;
        $this->log = $log;
        $this->message = $message;
    }

    /**
     * Send the mail message
     *
     * @return bool
     * @throws MissingValuesException
     */
    public function send()
    {
        if(!$this->message->verifyRequiredValues())
        {
            throw new MissingValuesException('Some required email values are missing');
        };

        // Add default headers if headers are still empty
        if(!$this->message->headers)
        {
            $this->message->headers($this->getDefaultHeaders());
        }

        $message = $this->message;

        $result = $this->handle($message);

        if ( $this->enable_log ) $this->log->info($this->logLine($message));

        return $result;
    }

    /**
     * @param $message
     * @return mixed
     */
    protected function handle($message)
    {
        $result = $this->laravelMailer->send($message->template, $message->data, function ($msg) use ($message)
        {
            foreach ( $message->headers as $header => $value ) $msg->getSwiftMessage()->getHeaders()->addTextHeader($header, $value);

            $msg->from($message->from->email, $message->from->name);
            $msg->to($message->to->email, $message->to->name);
            if ( $message->cc ) $msg->cc($message->cc->email, $message->cc->name);
            if ( $message->bcc ) $msg->bcc($message->bcc->email, $message->bcc->name);

            $msg->subject($message->subject);
        });

        return $result;
    }

    /**
     * Construct a log line
     *
     * @param Message $message
     * @return string
     */
    protected function logLine(Message $message)
    {
        return 'Mail ['.$message->subject.'] sent to ['.$message->to->email.']';
    }

    public function __call($method, $args)
    {
        if ( method_exists($this->message, $method) )
        {
            $this->message = call_user_func_array([$this->message,$method],$args);

            return $this;
        }

        throw new BadMethodCallException('Method [' . $method . '] not found on Mailer or Message class');
    }

    public function getDefaultHeaders()
    {
        return [];
    }


}