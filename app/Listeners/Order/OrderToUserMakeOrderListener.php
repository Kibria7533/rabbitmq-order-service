<?php

namespace App\Listeners\Order;

use App\Facade\RabbitMQFacade;
use App\Services\RabbitMQService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Connectors\RabbitMQConnector;

class OrderToUserMakeOrderListener implements ShouldQueue
{
    private RabbitMQConnector $connector;
    private RabbitMQService $rabbitmqService;

    /** Set rabbitmq config where this event is going to publish */
    private const EXCHANGE_CONFIG_NAME = 'user';
    private const QUEUE_CONFIG_NAME = 'orderMake';
    private const RETRY_MECHANISM = true;

    /**
     * @throws Exception
     */
    public function __construct(RabbitMQConnector $connector, RabbitMQService $rabbitmqService)
    {
        Log::info('Listener called');
        $this->connector = $connector;
        $this->rabbitmqService = $rabbitmqService;
        RabbitMQFacade::publishEvent(
            $this->connector,
            $this->rabbitmqService,
            self::EXCHANGE_CONFIG_NAME,
            self::QUEUE_CONFIG_NAME,
            self::RETRY_MECHANISM
        );
    }

    public function handle()
    {

    }
}
