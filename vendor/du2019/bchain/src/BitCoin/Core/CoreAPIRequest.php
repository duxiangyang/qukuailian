<?php
namespace Du2019\BitCoin\Core;
/**
 * Class CoreAPIRequest
 */
class CoreAPIRequest
{
	const ERROR_INVALID_METHOD = 601;
	const ERROR_INVALID_PARAM = 602;
	const ERROR_EXCEPTION_THROWN = 603;
	const ERROR_API_CALL = 604;
	/**
	 * @var string|null
	 */
	private $api_call = null;

	/**
	 * @return string|null
	 */
	public function getAPICall()
	{
		return $this->api_call;
	}

	/**
	 * CoreAPIRequest constructor.
	 * @param APIResponse $api_response
	 */
	public function __construct($user_name,$password,$rpc_host,$rpc_port){
		$this->api_call = 'http://';
		$this->api_call .= $user_name.':'.$password.'@';
		$this->api_call .= $rpc_host.':'.$rpc_port. '/';
	}


	/**
	 * @var array Array of valid params - to be improved as needed
	 */
	private static $valid_params = array(
		'account',
		'confirmations',
		'watchOnly',
		'count',
		'skip',
        'seans',
        'donation',
        'sendAmount',
        'transHash'
	);

	/**
	 * @var array
	 */
	private $params = array();

	/**
	 * @param array $params
	 */
	public function addParams(array $params)
	{
		foreach ($params as $key => $value)
		{
			if (!$this->addParam($key, $value))
			{
				//$this->api_response->displayFailure(self::ERROR_INVALID_PARAM, "Invalid param provided $key, please check documentation.");
			}
		}
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @return bool
	 */
	public function addParam($key, $value)
	{
		if (in_array($key, self::$valid_params))
		{
			if ($value === 'false' || $value === 'true')
			{
				$value = (bool)$value;
			}
			else if (is_numeric($value))
			{
				$value = (float)$value;
			}
			$this->params[$key] = $value;
			return true;
		}
		return false;
	}

	/**
	 * Call: getinfo
	 * Method: GET
	 * Params: N/A
	 */
	const METHOD_GET_GETINFO = 'getinfo';

	/**
	 * @throws CoreAPIRequestException
	 */
	public function getInfo()
	{
		$response = $this->do_request(self::METHOD_GET_GETINFO);
		$output = $response['result'];
		return $output;
	}

	/**
	 * Call: getbalance
	 * Method: GET
	 * Params:
	 * - "account" [string] (Optional) An account name, use * to display ALL, empty string to display default account.
	 * - "confirmations" [int] (Optional) The minimum number of confirmations.
	 * - "watchOnly" [bool] (Optional) Whether to include watch-only addresses.
	 */
	const METHOD_GET_GETBALANCE = 'getbalance';

	/**
	 * @throws CoreAPIRequestException
	 */
	public function getBalance()
	{
		$params = array();
		$account = '*';
		if (isset($this->params['account']))
		{
			$params[] = $this->params['account'];
			$account = $this->params['account'];
			if (isset($this->params['confirmations']))
			{
				$params[] = (int)$this->params['confirmations'];
				if (isset($this->params['watchOnly']))
				{
					//$params[] = $this->params['watchOnly'];
				}
			}
		}
		$response = $this->do_request(self::METHOD_GET_GETBALANCE, $params);
		$output = array(
			'account' => $account,
			'balance' => $response['result']
		);
		$this->api_response->setResult($output);
	}

    /**
     * Call: getbalance
     * Method: GET
     * Params:
     * - "account" [string] (Optional) An account name, use * to display ALL, empty string to display default account.
     * - "confirmations" [int] (Optional) The minimum number of confirmations.
     * - "watchOnly" [bool] (Optional) Whether to include watch-only addresses.
     */
    const METHOD_GET_NEWADDRESS = 'getnewaddress';

    /**
     * @throws CoreAPIRequestException
     */
    public function getNewAddress()
    {
        $params = array();
        $account = '*';
        if (isset($this->params['account']))
        {
            $params[] = $this->params['account'];
            $account = $this->params['account'];
            if (isset($this->params['confirmations']))
            {
                $params[] = (int)$this->params['confirmations'];
                if (isset($this->params['watchOnly']))
                {
                    $params[] = $this->params['watchOnly'];
                }
            }
        }
        $response = $this->do_request(self::METHOD_GET_NEWADDRESS, $params);
        $output = array(
            'account' => $account,
            'balance' => $response['result']
        );
        $this->api_response->setResult($output);
    }

    const METHOD_GET_TRANSACTION = 'gettransaction';

    /**
     * @throws CoreAPIRequestException
     */
    public function getTransaction()   //gettransaction
    {
        $params = array();
        if (isset($this->params['transHash']))
        {
            $params[] = $this->params['transHash'];
        }
        $response = $this->do_request(self::METHOD_GET_TRANSACTION, $params);
        $output = array(
            'account' => '',
            'balance' => $response['result']
        );
        $this->api_response->setResult($output);
    }


    const METHOD_SEND_TOADDRSS = 'sendtoaddress';

    /**
     * @throws CoreAPIRequestException
     */
    public function sendToAddress()
    {
        $params = array();
        if (isset($this->params['account']))
        {
            $params[] = $this->params['account'];
            $account = $this->params['account'];
            if(isset($this->params['sendAmount'])){
                $params[] = $this->params['sendAmount'];
                if (isset($this->params['donation']))
                {
                    $params[] = $this->params['donation'];
                    if (isset($this->params['seans']))
                    {
                        $params[] = $this->params['seans'];
                    }
                }
            }

        }
        $response = $this->do_request(self::METHOD_SEND_TOADDRSS, $params);
        $output = array(
            'account' => $account,
            'hash' => $response['result']
        );
        $this->api_response->setResult($output);
    }


    /**
	 * Call: getwalletinfo
	 * Method: GET
	 * Params: N/A
	 */
	const METHOD_GET_GETWALLETINFO = 'getwalletinfo';

	/**
	 * @throws CoreAPIRequestException
	 */
	public function getWalletInfo()
	{
		$response = $this->do_request(self::METHOD_GET_GETWALLETINFO);
		$output = $response['result'];
		$this->api_response->setResult($output);
	}

	/**
	 * Call: getpeerinfo
	 * Method: GET
	 * Params: N/A
	 */
	const METHOD_GET_GETPEERINFO = 'getpeerinfo';

	/**
	 * @throws CoreAPIRequestException
	 */
	public function getPeerInfo()
	{
		$response = $this->do_request(self::METHOD_GET_GETPEERINFO);
		$output = $response['result'];
		$this->api_response->setResult($output);
	}

	/**
	 * Call: listtransactions
	 * Method: GET
	 * Params:
	 * - "account" [string] (Optional) The name of an account to get transactions from. Use an empty string (“”) to get transactions for the default account. (Default  *)
	 * - "count" [int] (Optional) The number of the most recent transactions to list. (Default 10)
	 * - "skip" [int] (Optional) The number of the most recent transactions which should not be returned. Allows for pagination of results. (Default 0)
	 * - "watchOnly" [bool] (Optional) Whether to include watch-only addresses. (Default false)
	 */
	const METHOD_GET_LISTRANSACTIONS = 'listtransactions';

	/**
	 * @throws CoreAPIRequestException
	 */
	public function listTransactions()
	{
		$params = array();

		$account = '*';
		if (isset($this->params['account']))
		{
			$account = $this->params['account'];
		}
		$params[] = $account;

		$count = 10;
		if (isset($this->params['count']))
		{
			$count = $this->params['count'];
		}
		$params[] = $count;

		$skip = 0;
		if (isset($this->params['skip']))
		{
			$skip = $this->params['skip'];
		}
		$params[] = $skip;

		$watch_only = false;
		if (isset($this->params['watchOnly']))
		{
			$watch_only = $this->params['watchOnly'];
		}
		$params[] = $watch_only;

		$response = $this->do_request(self::METHOD_GET_LISTRANSACTIONS, $params);

		$output = array(
			'account' => $account,
			'watchOnly' => $watch_only,
			'transactions' => $response['result']
		);

		$this->api_response->setResult($output);
	}

	/**
	 * @param string $method
	 * @param array $params
	 * @return array
	 * @throws CoreAPIRequestException
	 */
	private function do_request($method, $params = array())
	{
		$ch = curl_init();

		$http_header = array('Content-Type: text/plain');
		$post_fields = array();
		$post_fields['jsonrpc'] = '1.0';
		$post_fields['id'] = "core_api_request_$method";
		$post_fields['method'] = $method;
		$post_fields['params'] = $params;
		$json_post = json_encode($post_fields);
		echo $this->getAPICall(); exit();
		curl_setopt($ch, CURLOPT_URL, $this->getAPICall());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		$result = curl_exec($ch);
		echo $result.'===================='; exit();
	    $result_array = json_decode($result,true);
	    echo '<pre>';
	        print_r($result_array);
	        exit();

		if ($result === false)
		{
			$curl_error = curl_error($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			if ($http_code !== 200)
			{
				throw new CoreAPIRequestException('Curl error: ' . $curl_error, CoreAPIRequestException::CURL_ERROR);
			}
		}

		$result = json_decode($result, true);
		if (!is_null($result['error']))
		{
			// Error in the API request
			$error_message = 'Bitcoin Core Error! ';
			if (isset($result['error']['code']))
			{
				$error_message .= 'Code: ' . $result['error']['code'];
			}
			if (isset($result['error']['message']))
			{
				$error_message .= ' Message: ' . $result['error']['message'];
			}
			$this->api_response->displayFailure(self::ERROR_API_CALL, $error_message);
		}

		return array(
			'call_id' => $result['id'],
			'result' => $result['result']
		);
	}
}