<?php
require_once ('vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

$host=' llama-01.rmq.cloudamqp.com';
$user='hkwjhjba';
$password='dmoBQu-yu17noxcebw_kjbflS4XK8hor';
$port=5672;
$vhost='hkwjhjba';
$exchange='sendOrReceiveData';
$queue='APIOrDBData';

$connection = new AMQPStreamConnection($host, $port, $user, $password,$vhost);


$channel = $connection->channel();


$channel->queue_declare($queue, false, true, false, false);


$channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);

$channel->queue_bind($queue, $exchange);

function queMessage($message){
	//expecting message to be json_encoded
	$messageBody = $message;
	$message = new AMQPMessage($messageBody, array('content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
	$channel->basic_publish($message, $exchange);
}
$channel->close();
$connection->close();


?>