<?php
namespace BeecommApi\Adapter;

interface Settings
{
	public function connect(...$fields);//string $client_id, string $client_secret
}

interface Options
{
	public function GetAuthorized();

	public function set_host(string $host);
	public function get_host();

	public function set_client_id(string $client_id);
	public function get_client_id();

	public function set_client_secret(string $client_secret);
	public function get_client_secret();

	public function set_customer_info(...$info);
	public function get_customer_info();
}

class BeecommInit implements Options
{
	private $host;
	private $client_id;
	private $client_secret;
	private $access_token;

	private $branchName;
	private $branchId;
	private $customerName;

	public function __construct(string $client_id, string $client_secret)
	{
		//$this->host = self::get_host();
		var_dump('construct');
		$this->host = 'https://biapp.beecomm.co.il:8094';
		//https://sushi.meat-night.co.il/checkout/order-received/8006/?key=wc_order_GGs9qFfmzZvMc

		self::set_client_id($client_id);
		self::set_client_secret($client_secret);
		self::GetAuthorized();
		self::GetCustomers();
	}

	public function set_client_secret(string $client_secret) {
		var_dump('set_client_secret');
		$this->client_secret = $client_secret;
	}

	public function get_client_secret(): string {
		return $this->client_secret;
	}

	public function set_client_id(string $client_id) {
		var_dump('set_client_id');
		$this->client_id = $client_id;
	}

	public function get_client_id(): string {
		return $this->client_id;
	}

	public function set_customer_info(...$info) {
		$this->branchName   = $info[0]['branchName'];
		$this->branchId     = $info[0]['branchId'];
		$this->customerName = $info[0]['customerName'];
	}

	public function get_customer_info(): array {
		return [$this->branchName, $this->branchId, $this->customerName];
	}

	public function get_access_token(): string {
		return $this->access_token;
	}

	public function set_access_token(string $access_token) {
		$this->access_token = $access_token;
	}

	public function get_host(): string {
		return $this->host;
	}

	public function set_host(string $host) {
		$this->host = $host;
	}

	/**
	 * Set Token Access by GetAuthorized method from Api
	 */
	public function GetAuthorized(): void//string $client_id, string $client_secret
	{
		$url = $this->host.'/v2/oauth/token';
		$fields = array('client_id'=>self::get_client_id(), 'client_secret'=>self::get_client_secret());
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "utf-8",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => http_build_query($fields),
			CURLOPT_HTTPHEADER => [
				"Content-Type: application/x-www-form-urlencoded",
				//'Content-Type: application/json',
				//'Accept: application/json'
			],
		]);

		$response = curl_exec($curl);

		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$data = json_decode($response, true);
			self::set_access_token($data['access_token']);
		}
		//var_dump(self::get_access_token());
	}

	/**
	 * Get Customer by token
	 */
	public function GetCustomers(): void
	{
		$url = $this->host.'/api/v2/services/orderCenter/customers';
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				//'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
				'x-access-token:'.self::get_access_token(),
				'access_token:'.self::get_access_token(),
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$data = json_decode($response, true);
			self::set_customer_info($data['customers'][0]);
		}
		var_dump(self::get_customer_info());
	}
}