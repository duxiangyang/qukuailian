<?php
require_once "./../../vendor/autoload.php";
use Du2019\Ethereum\Client as EthereumClient;
use Du2019\Tools\Tool;

$client = new EthereumClient([
    'base_uri' => 'https://ropsten.infura.io/v3/31090cb004d34600b113fa3e4203e9b5',
    'timeout' => 30,
]);
echo "<pre>";
$cv = $client->web3_clientVersion();
print_r($cv);
echo "<br>";
$a = "";
print_r($a);
$nv = $client->eth_getBalance('0xa4e338dF6c6d9Eb13a6fD4B06F87E7BFD757bb1d','latest');
$nv_we = Tool::hexToDec($nv);
print_r($nv_we);
echo "<br>";
$s = Tool::weiToEth($nv_we,false);
print_r($s);
echo "<br>";