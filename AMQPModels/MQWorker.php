<?php
/**
 * Created by PhpStorm.
 * User: ahmetgunes
 * Date: 14.04.2016
 * Time: 20:48
 */

namespace AMQPModels;


use PhpAmqpLib\Message\AMQPMessage;

class MQWorker
{

    /**
     * @var MQService
     */
    protected $rabbit;

    public function __construct(MQService $rabbit)
    {
        $this->rabbit = $rabbit;
    }

    public function sendToQueue(AMQPMessage $message, $queue)
    {
        $this->rabbit->getChannel()->basic_publish($message, '', $queue);
    }

    public function wait()
    {
        $channel = $this->rabbit->getChannel();
        $processCoordinate = function (AMQPMessage $message) use ($channel){
            $messageBody = json_decode($message->getBody());
            var_dump($messageBody);
            try {
                $channel->basic_ack($message->delivery_info['delivery_tag']);
            } catch (\Exception $exc) {
                $channel->basic_reject($message->delivery_info['delivery_tag'], true);
            }
        };
        $channel->basic_consume('interest-queue', '', false, false, false, false, $processCoordinate);

        while(count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->rabbit->getConnection()->close();
    }
}