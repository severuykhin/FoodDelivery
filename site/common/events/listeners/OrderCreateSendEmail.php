<?php

namespace common\events\listeners;

use common\events\Event;

class OrderCreateSendEmail
{

    private $emails;
    private $mailer;
    private $supportEmail;

    public function __construct($mailer, array $emails, string $supportEmail)
    {
        $this->emails = $emails;
        $this->mailer = $mailer;    
        $this->supportEmail = $supportEmail;
    }

    public function handle(Event $event) 
    {
        foreach($this->emails as $email) {
            // var_dump($this->supportEmail); die;
            $this->mailer->compose('order', [
                'model' => $event->order
            ])
            ->setFrom([$this->supportEmail => 'shymovka43.ru'])
            ->setTo($email)
            ->setSubject('Заявка на доставку shymovka43.ru')
            ->send();
        }
    }
}