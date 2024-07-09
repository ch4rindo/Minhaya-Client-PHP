<?php

declare(strict_types=1);

namespace charindo\MinhayaScraping;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class MinhayaClient{

	private Client $client;
	private string $token;
	private string $resVersion = "27";

	public function __construct($token){
		$this->token = $token;

		$this->client = new Client([
			RequestOptions::COOKIES => true,
			RequestOptions::HEADERS => [
				"User-Agent" => "Ktor client"
			],
			RequestOptions::VERIFY => false,
			RequestOptions::HTTP_ERRORS => false,
			RequestOptions::DEBUG => false,
			RequestOptions::ALLOW_REDIRECTS => ["max" => 10],
			"curl" => [
				CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_3,
				CURLOPT_SSL_CIPHER_LIST => "ECDHE+AESGCM"
			]
		]);
	}

	public function getQuizById(int $id) : array{
		$response = $this->client->get('https://api-v1.minhaya.com/quiz?quizId=' . $id, [
			RequestOptions::HEADERS => [
				"accept" => "application/json",
				"authorization" => "Bearer " . $this->token,
				"accept-charset" => "UTF-8",
				"accept-language" => "ja",
				"accept-encoding" => "gzip, deflate, br",
				"platform" => "iOS",
				"content-length" => "0",
				"minhaya-res-version" => $this->resVersion,
				"device" => "iPhone15,3",
				"os-version" => "18.0"
			]
		]);

		return json_decode($response->getBody()->getContents(), true);
	}

	public function getHistory(int $max = 20) : array{
		$response = $this->client->get('https://api-v1.minhaya.com/quiz/history?start=0&size=' . $max, [
			RequestOptions::HEADERS => [
				"accept" => "application/json",
				"authorization" => "Bearer " . $this->token,
				"accept-charset" => "UTF-8",
				"accept-language" => "ja",
				"accept-encoding" => "gzip, deflate, br",
				"platform" => "iOS",
				"content-length" => "0",
				"minhaya-res-version" => $this->resVersion,
				"device" => "iPhone15,3",
				"os-version" => "18.0"
			]
		]);

		return json_decode($response->getBody()->getContents(), true);
	}

	public function getReading(string $text) : string{
		$response = $this->client->get('https://api-v1.minhaya.com/reading?text=' . $text, [
			RequestOptions::HEADERS => [
				"accept" => "application/json",
				"authorization" => "Bearer " . $this->token,
				"accept-charset" => "UTF-8",
				"accept-language" => "ja",
				"accept-encoding" => "gzip, deflate, br",
				"platform" => "iOS",
				"content-length" => "0",
				"minhaya-res-version" => $this->resVersion,
				"device" => "iPhone15,3",
				"os-version" => "18.0"
			]
		]);

		return json_decode($response->getBody()->getContents(), true)["reading"];
	}

	public function getReadingSuggest(string $text) : array{
		$response = $this->client->get('https://api-v1.minhaya.com/reading/suggest?text=' . $text, [
			RequestOptions::HEADERS => [
				"accept" => "application/json",
				"authorization" => "Bearer " . $this->token,
				"accept-charset" => "UTF-8",
				"accept-language" => "ja",
				"accept-encoding" => "gzip, deflate, br",
				"platform" => "iOS",
				"content-length" => "0",
				"minhaya-res-version" => $this->resVersion,
				"device" => "iPhone15,3",
				"os-version" => "18.0"
			]
		]);

		return json_decode($response->getBody()->getContents(), true);
	}

	public function makeQuizList(string $name) : array{
		$response = $this->client->post('https://api-v1.minhaya.com/make_quiz_list', [
			RequestOptions::JSON => [
				"name" => $name,
			],
			RequestOptions::HEADERS => [
				"accept" => "application/json",
				"authorization" => "Bearer " . $this->token,
				"accept-charset" => "UTF-8",
				"accept-language" => "ja",
				"accept-encoding" => "gzip, deflate, br",
				"platform" => "iOS",
				"content-length" => "21",
				"minhaya-res-version" => $this->resVersion,
				"device" => "iPhone15,3",
				"os-version" => "18.0"
			]
		]);

		return json_decode($response->getBody()->getContents(), true);
	}

	public function makeQuizToQuizList(int $quizListId, string $question, string $answer, array $readings) : array{
		$response = $this->client->post('https://api-v1.minhaya.com/make_quiz_list/' . $quizListId . '/quiz', [
			RequestOptions::JSON => [
				"answer" => $answer,
				"question" => $question,
				"quizListId" => $quizListId,
				"readings" => $readings
			],
			RequestOptions::HEADERS => [
				"accept" => "application/json",
				"authorization" => "Bearer " . $this->token,
				"accept-charset" => "UTF-8",
				"accept-language" => "ja",
				"accept-encoding" => "gzip, deflate, br",
				"platform" => "iOS",
				"content-length" => "21",
				"minhaya-res-version" => $this->resVersion,
				"device" => "iPhone15,3",
				"os-version" => "18.0"
			]
		]);

		return json_decode($response->getBody()->getContents(), true);
	}
}