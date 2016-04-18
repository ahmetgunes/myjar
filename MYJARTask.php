<?php

require_once __DIR__.'/vendor/autoload.php';

/**
 * Created by PhpStorm.
 * User: ahmetgunes
 * Date: 14.04.2016
 * Time: 20:32
 */

$mqHost = 'impact.ccat.eu';
$mqUser = 'myjar';
$mqPassword = 'myjar';
$mqService = new \AMQP\MQService($mqHost, $mqUser, $mqPassword);
$amqpWorker = new \AMQP\MQWorker($mqService);
$amqpWorker->wait();