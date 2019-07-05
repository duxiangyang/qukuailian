<?php
require_once "./../../vendor/autoload.php";
use Du2019\Ethereum\Client as EthereumClient;
use Du2019\Tools\Tool;
$contract = "0x78f64a42f9521093f452f6211f3a3059661553d4";
$client = new EthereumClient([
    'base_uri' => 'https://ropsten.infura.io/v3/31090cb004d34600b113fa3e4203e9b5',
    'timeout' => 30,
]);
//获取代币小数位数
$params = [
    "to" => $contract,
    "data" => "0x313ce567"
];
$ec = $client->eth_call($params,'latest');
echo "代币小数位数： " . Tool::hexToDec($ec);
echo "<br>".PHP_EOL;

//获取账户代币余额
$params = [
    "to" => $contract,
    "data" => "0x70a0823100000000000000000000000075909f9f371a54abb4A08243eF4d4A274b9107f7"
];
$ec = $client->eth_call($params,'latest');
//print_r($ec);
echo "账户代币余额：" . Tool::weiToEth($ec);
echo "<br>".PHP_EOL;


//获取代币总量
$params = [
    "to" => $contract,
    "data" => "0x18160ddd"
];
$ec = $client->eth_call($params,'latest');
//print_r($ec);
echo "代币发行总量：" . Tool::weiToEth($ec);
echo "<br>".PHP_EOL;

//symbol 简称
$params = [
    "to" => $contract,
    "data" => "0x95d89b41"
];
$ec = $client->eth_call($params,'latest');
$str = Tool::Hex2String(substr($ec,130));
echo "symbol 简称：" . $str;
echo "<br>".PHP_EOL;

//name 名称
$params = [
    "to" => $contract,
    "data" => "0x06fdde03"
];
$ec = $client->eth_call($params,'latest');
$str = Tool::Hex2String(substr($ec,130));
echo "name 名称：" . $str;
echo "<br>".PHP_EOL;