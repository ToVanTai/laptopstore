<?php
include_once __DIR__ . "/../vendor/autoload.php";
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQSender
{
    private $connection;
    private $channel;
    private $queueName;

    public function __construct($queueName, $config)
    {
        $this->queueName = $queueName;
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($queueName, $config['passive'], $config['durable'], $config['exclusive'], $config['auto_delete']);
        // $this->channel->queue_declare($queueName, false, true, false, false);
    }
    /**
     * delivery_mode: 1 lưu ở ram. 2 lưu ở đĩa
     * expiration: thời gian số số giây * 1000
     */
    public function send($message, $config)
    {
        try {
            if(isset($config['expiration'])){
                $message = new AMQPMessage($message, [
                    'delivery_mode' => $config['delivery_mode'],
                    'expiration' => $config['expiration']
                ]);
                $this->channel->basic_publish($message, '', $this->queueName);
            }else{
                $message = new AMQPMessage($message, [
                    'delivery_mode' => $config['delivery_mode']
                ]);
                $this->channel->basic_publish($message, '', $this->queueName);
            }
            
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
?>