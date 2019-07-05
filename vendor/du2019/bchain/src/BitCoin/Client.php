<?php
namespace Du2019\BitCoin;

use Du2019\BitCoin\Core\CoreAPIRequest;

require_once __DIR__.'/Core/CoreAPIRequest.php';

class Client{
    protected $uname;
    protected $passwd;
    protected $host_ip;
    protected $host_port;
    /**
     * 构造配置信息
     * @author duxiangyang
     * @datetime 2019/7/5 16:12
     * @param $uname 用户名
     * @param $passwd 密码
     * @param $host_ip ip地址
     * @param $host_port 端口
     */
    function __construct($uname,$passwd,$host_ip,$host_port){
        $this->uname = $uname;
        $this->passwd = $passwd;
        $this->host_ip = $host_ip;
        $this->host_port = $host_port;
    }

    /**
	 * @param string $method
	 */
	function handle_post($method,$params){
		try {
			$core_api = new CoreAPIRequest($this->uname,$this->passwd,$this->host_ip,$this->host_port);
            $core_api->addParams($params);
			switch ($method){
                case CoreAPIRequest::METHOD_GET_TRANSACTION:
                    $core_api->getTransaction();
                    break;
				case CoreAPIRequest::METHOD_GET_GETINFO:
					$core_api->getInfo();
					break;
                case CoreAPIRequest::METHOD_GET_NEWADDRESS:
                    $core_api->getNewAddress();
                    break;
                case CoreAPIRequest::METHOD_SEND_TOADDRSS:
                    $core_api->sendToAddress();
                    break;
				case CoreAPIRequest::METHOD_GET_GETBALANCE:
					$core_api->getBalance();
					break;
				case CoreAPIRequest::METHOD_GET_GETWALLETINFO:
					$core_api->getWalletInfo();
					break;
				case CoreAPIRequest::METHOD_GET_GETPEERINFO:
					$core_api->getPeerInfo();
					break;
				case CoreAPIRequest::METHOD_GET_LISTRANSACTIONS:
					$core_api->listTransactions();
					break;
				default:
					break;
			}

		}
		catch (CoreAPIRequestException $e){

		}
	}


}