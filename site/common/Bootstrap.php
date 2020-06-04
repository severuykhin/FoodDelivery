<?php

namespace common;

use Yii;
use yii\base\BootstrapInterface;
use common\events\EventDispatcher;
use common\events\listeners\OrderCreateSendEmail;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {   
        Yii::$container->setSingleton('common\events\EventDispatcher', function () use ($app) {
            return new EventDispatcher([
                'common\events\OrderCreateEvent' => [
                    'common\events\listeners\OrderCreateSendEmail'
                ]
            ]);
        });

        Yii::$container->set('common\events\listeners\OrderCreateSendEmail', function () use ($app) {
            return new OrderCreateSendEmail(
                $app->mailer,
                $app->params['emails'],
                $app->params['supportEmail']
            );
        });
    }
}