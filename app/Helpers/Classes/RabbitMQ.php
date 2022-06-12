<?php

namespace App\Helpers\Classes;

use App\Services\RabbitMQService;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Connectors\RabbitMQConnector;

class RabbitMQ
{
    /**
     * @throws AMQPProtocolChannelException
     * @throws Exception
     */
    public function publishEvent(
        RabbitMQConnector $connector, RabbitMQService $rabbitMqService, string $configExchangeName, string $configQueueName, bool $retry = false
    ): void
    {
        /** Alternate Exchange related variables */
        $alternateExchange = config('rabbitmq.exchanges.' . $configExchangeName . '.alternateExchange.name');
        $alternateExchangeType = config('rabbitmq.exchanges.' . $configExchangeName . '.alternateExchange.type');
        $alternateExchangeDurable = config('rabbitmq.exchanges.' . $configExchangeName . '.alternateExchange.durable');
        $alternateExchangeAutoDelete = config('rabbitmq.exchanges.' . $configExchangeName . '.alternateExchange.autoDelete');
        $alternateQueue = config('rabbitmq.exchanges.' . $configExchangeName . '.alternateExchange.queue');
        $alternateQueueDurable = config('rabbitmq.exchanges.' . $configExchangeName . '.alternateExchange.queueDurable');
        $alternateQueueAutoDelete = config('rabbitmq.exchanges.' . $configExchangeName . '.alternateExchange.queueAutoDelete');
        $alternateQueueMode = config('rabbitmq.exchanges.' . $configExchangeName . '.alternateExchange.queueMode');

        /** Exchange Queue related variables */
        $exchange = config('rabbitmq.exchanges.' . $configExchangeName . '.name');
        $type = config('rabbitmq.exchanges.' . $configExchangeName . '.type');
        $durable = config('rabbitmq.exchanges.' . $configExchangeName . '.durable');
        $autoDelete = config('rabbitmq.exchanges.' . $configExchangeName . '.autoDelete');
        $exchangeArguments = [
            'alternate-exchange' => $alternateExchange
        ];
        $queueName = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.name');
        $binding = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.binding');
        $queueDurable = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.durable');
        $queueAutoDelete = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.autoDelete');
        $queueMode = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.queueMode');

        /** Set Config to publish the event message */
        config([
            'queue.connections.rabbitmq.options.exchange.name' => $exchange,
            'queue.connections.rabbitmq.options.queue.exchange' => $exchange,
            'queue.connections.rabbitmq.options.exchange.type' => $type,
            'queue.connections.rabbitmq.options.queue.exchange_type' => $type,
            'queue.connections.rabbitmq.options.queue.exchange_routing_key' => $binding
        ]);

        /** Create connection with RabbitMQ server */
        $config = config('queue.connections.rabbitmq');
        $queue = $connector->connect($config);

        /** Create Alternate Exchange, Queue and Bind Queue with Alternate Exchange */
        $alternateExchangePayload = [
            'exchange' => $alternateExchange,
            'type' => $alternateExchangeType,
            'durable' => $alternateExchangeDurable,
            'autoDelete' => $alternateExchangeAutoDelete,
            'queueName' => $alternateQueue,
            'binding' => "",
            'queueDurable' => $alternateQueueDurable,
            'queueAutoDelete' => $alternateQueueAutoDelete,
            'queueMode' => $alternateQueueMode
        ];
        $rabbitMqService->createExchangeQueueAndBind($queue, $alternateExchangePayload, false);

        /** Create Exchange, Queue and Bind Queue with Exchange */
        $exchangePayload = [
            'exchange' => $exchange,
            'type' => $type,
            'durable' => $durable,
            'autoDelete' => $autoDelete,
            'exchangeArguments' => $exchangeArguments,
            'queueName' => $queueName,
            'binding' => $binding,
            'queueDurable' => $queueDurable,
            'queueAutoDelete' => $queueAutoDelete,
            'queueMode' => $queueMode
        ];
        Log::info($exchangePayload);
        if ($retry) {
            /** DlX-DLQ related variables */
            $dlx = config('rabbitmq.exchanges.' . $configExchangeName . '.dlx.name');
            $dlxType = config('rabbitmq.exchanges.' . $configExchangeName . '.dlx.type');
            $dlxDurable = config('rabbitmq.exchanges.' . $configExchangeName . '.dlx.durable');
            $dlxAutoDelete = config('rabbitmq.exchanges.' . $configExchangeName . '.dlx.autoDelete');
            $dlq = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.dlq.name');
            $messageTtl = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.dlq.x_message_ttl');
            $dlqDurable = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.dlq.durable');
            $dlqAutoDelete = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.dlq.autoDelete');
            $dlqQueueMode = config('rabbitmq.exchanges.' . $configExchangeName . '.queue.' . $configQueueName . '.dlq.queueMode');


            $exchangePayload['dlx'] = $dlx;
            $exchangePayload['dlxType'] = $dlxType;
            $exchangePayload['dlxDurable'] = $dlxDurable;
            $exchangePayload['dlxAutoDelete'] = $dlxAutoDelete;
            $exchangePayload['dlq'] = $dlq;
            $exchangePayload['messageTtl'] = $messageTtl;
            $exchangePayload['dlqDurable'] = $dlqDurable;
            $exchangePayload['dlqAutoDelete'] = $dlqAutoDelete;
            $exchangePayload['dlqQueueMode'] = $dlqQueueMode;

            $rabbitMqService->createExchangeQueueAndBind($queue, $exchangePayload, true);
        } else {
            $rabbitMqService->createExchangeQueueAndBind($queue, $exchangePayload, false);
        }
    }
}
