<?php

namespace common\services;

use common\interfaces\NotifierInterface;

class EmailNotifier implements NotifierInterface
{

    private $adminEmail;

    public function __construct(string $adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }

    public function notify($email, $view, $data, $subject)
    {

    }
}