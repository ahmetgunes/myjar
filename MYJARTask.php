<?php

require_once __DIR__.'/vendor/autoload.php';

/**
 * Created by PhpStorm.
 * User: ahmetgunes
 * Date: 14.04.2016
 * Time: 20:32
 */
require_once 'AMQPModels/MQService.php';
require_once 'AMQPModels/MQWorker.php';
require_once 'InterestModels/Interest.php';

$mqHost = 'impact.ccat.eu';
$mqUser = 'myjar';
$mqPassword = 'myjar';
$mqService = new \AMQPModels\MQService($mqHost, $mqUser, $mqPassword);
$amqpWorker = new \AMQPModels\MQWorker($mqService);
$amqpWorker->wait();