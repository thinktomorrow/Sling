<?php namespace Sling;

use Exception;

class AdminMailer {

    protected $mailer;

    /**
     * Instance as decorator pattern
     *
     * @param    BaseMailer $mailer
     */
    public function __construct(BaseMailer $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendExceptionMailToAdmin(Exception $exception)
    {
        $this->mailer->to('cavensben@gmail.com','Ben Cavens')
                     ->from('cavensben@gmail.com','Ben Cavens')
                     ->subject('Code exception')
                     ->template('errors.exception')
                     ->data(compact('exception'));

        return $this->mailer->send();
    }

    public function sendErrorMailToAdmin($error_message)
    {
        $this->mailer->to('cavensben@gmail.com','Ben Cavens')
            ->from('cavensben@gmail.com','Ben Cavens')
            ->subject('Code error')
            ->template('errors.logged')
            ->data(compact('error_message'));

        return $this->mailer->send();
    }

}