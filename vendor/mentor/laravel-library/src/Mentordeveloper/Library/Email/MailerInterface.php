<?php namespace Mentordeveloper\Library\Email;

interface MailerInterface
{
    /**
     * Interface to send emails
     *
     * @param $to
     * @param $body
     * @param $subject
     * @param $template
     * @return boolean $success
     */
    public function sendTo($to, $body, $subject, $template);
}