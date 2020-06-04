<?php

namespace common\interfaces;

interface NotifierInterface 
{
    public function notify($email, $view, $data, $subject);
}