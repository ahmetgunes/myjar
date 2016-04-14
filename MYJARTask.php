<?php

require_once __DIR__.'/vendor/autoload.php';

/**
 * Created by PhpStorm.
 * User: ahmetgunes
 * Date: 14.04.2016
 * Time: 20:32
 */
require_once 'AMQPModels/MQService.php';
require_once 'InterestModels/Interest.php';

const MQ_HOST = 'http://impact.ccat.eu/';
const MQ_USER = 'myjar';
const MQ_PASSWORD = 'myjar';
$mqService = new \AMQPModels\MQService(MQ_HOST, MQ_USER, MQ_PASSWORD);
$amqpWorker = new \AMQPModels\MQWorker($mqService);
$interest = new \InterestModels\Interest(10, 579);
echo $interest->calculateTotalInterest();
