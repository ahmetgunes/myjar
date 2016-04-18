<?php

namespace AMQP;

/**
 * Created by PhpStorm.
 * User: ahmetgunes
 * Date: 14.04.2016
 * Time: 20:32
 */


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MQService
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel;

    public function __construct($rabbitHost, $username, $password, $rabbitPort = 5672)
    {
        $this->connection = new AMQPStreamConnection($rabbitHost, $rabbitPort, $username, $password);
        $this->channel = $this->connection->channel();
    }

    /**
     * @return AMQPStreamConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param AMQPStreamConnection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param AMQPChannel $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }
}
