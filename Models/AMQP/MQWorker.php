<?php
/**
 * Created by PhpStorm.
 * User: ahmetgunes
 * Date: 14.04.2016
 * Time: 20:48
 */

namespace AMQP;


use Interest\Interest;
use PhpAmqpLib\Channel\AMQPChannel;
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
        try {
            $this->rabbit->getChannel()->basic_publish($message, '', $queue);
        } catch (\Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function wait()
    {
        $channel = $this->rabbit->getChannel();
        $interest = new Interest();
        $processLoan = function (AMQPMessage $message) use ($channel, $interest) {
            try {

                $messageBody = json_decode($message->getBody());
                if (is_numeric($messageBody->sum) && is_numeric($messageBody->days) &&
                    $messageBody->sum > 0 && $messageBody->days > 0) {
                    echo $message->getBody() . PHP_EOL;
                    $interest->setAmount($messageBody->sum);
                    $interest->setDays($messageBody->days);
                    $calculatedLoanInfo = $interest->getLoanResult();
                    $response = json_encode($calculatedLoanInfo);
                    $response = new AMQPMessage($response, array('content_type' => 'text/json', 'delivery_mode' => 2));
                    $this->sendToQueue($response, 'solved-interest-queue');
                } else {
                    $channel->basic_reject($message->delivery_info['delivery_tag'], false);
                }
            } catch (\Exception $exc) {
                $channel->basic_reject($message->delivery_info['delivery_tag'], false);
            }
        };
        $channel->basic_consume('interest-queue', null, false, false, false, false, $processLoan);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->rabbit->getConnection()->close();
    }
}