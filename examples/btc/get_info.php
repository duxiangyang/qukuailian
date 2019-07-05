<?php
require_once "./../../vendor/autoload.php";
use Du2019\BitCoin\Client as BitCoin;
$rpc_host = '47.94.243.250';
$rpc_post = '8332';
$uname = 'diankamu';
$passwd = 'Diankamu2019';

$bit_client = new BitCoin($uname,$passwd,$rpc_host,$rpc_post);

$bit_client->handle_post('getnewaddress',[]);