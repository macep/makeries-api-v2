<?php

use GuzzleHttp\Client;

class ApiV2 {

    private $baseUri = null;
    private $xTotalCount;
    private $pagination;
    private $httpCode;
    private $responseContent;
    private $responseBody;
    private $responseHeaders;
    private $doRedirectOnFail;

    private $responseHadError = false;
    private $responseError = null;
    private $responseIsJson = null;

    public function __construct() {
        $this->baseUri = Config::getKey('api','url');
    }

    public function get($url, $params = []) {
        $options = $this->getHeaders();
        $this->request('GET', $url, $options);
        $this->checkResponseErrors();
    }

    public function add($url, $params = [], $files = []) {
        $this->request('POST', $url, $this->loadOptions($params, $files));
        $this->checkResponseErrors(201);
    }

    public function update($url, $params = [], $files = []) {
        $this->request('PUT', $url, $this->loadOptions($params, $files));
        $this->checkResponseErrors();
    }

    public function delete($url, $params = []) {
        $options = $this->getHeaders();
        $this->request('DELETE', $url, $options);
        $this->checkResponseErrors(204);
    }

    public function callPagination($url = '', $filter) {
        if (!isset($filter['perPage'])) {
            $filter['perPage'] = 4;
        }
        if (!isset($filter['pageNr'])) {
            $filter['pageNr'] = 1;
        }
        if (strpos($url, '?') === false) {
            $url .= '?';
        }
        $results = $this->get($url.'&page='.$filter['pageNr'].'&per_page='.$filter['perPage']);
        $data = null;
        $pagination = [];
        if (!$this->responseHadError()) {
            $data = $this->getResponseBodyJson();
            $pagination = Site::paginate($this->getResponseTotalCount(), $filter['pageNr'], $filter['perPage']);
        }
        return [
                'data' => $data,
                'pagination' => $pagination
            ];
    }

    private function checkResponseErrors($status = 200) {
        if ($status != $this->getHttpCode()) {
            $this->responseHadError = true;
        }
    }

    public function request($method, $url, $options) {
        $client = new Client([
            'base_uri' => $this->baseUri,
            'timeout'  => 2.0,
        ]);
        $response = $client->request($method, $url, $options);
        $this->httpCode = $response->getStatusCode();
        $this->responseBody = $response->getBody()->getContents();
        foreach ($response->getHeaders() as $name => $values) {
            if ('x-total-count' == strtolower($name)) {
                if (is_array($values)) {
                    $this->xTotalCount = $values[0];
                } else {
                    $this->xTotalCount = $values;
                }
            }
        }
    }
        
    private function getHeaders() {
        return [
            'http_errors' => false,
            'headers'=>[
                'User-Agent' => 'testing/1.0',
                'Accept'     => 'application/json',
                'token'=>$_SESSION['jwt']
             ]
        ];
    }

    private function loadOptions($params, $files) {
        $options = $this->getHeaders();
        if (count($files)) {
            $options['multipart'] = [];
            foreach ($params as $paramName=>$paramValue) {
                array_push($options['multipart'], ['name'=>$paramName, 'contents'=>$paramValue]);
            }
            foreach ($files as $fieldName => $fileData) {
                array_push($options['multipart'], [
                            'name'=>$fieldName,
                            'contents'=>file_get_contents($fileData['tmp_name']),
                            'filename'=>$fileData['name']
                        ]);
            }
        } else {
            $options['form_params'] = $params;
        }
        return $options;
    }

    public function getOne($url, $params = []) {
        $this->get($url, $params);
        return $this->getResponseBodyJson();
    }

    public function getJson($url, $params = []) {
        $this->get($url, $params);
        return $this->getResponseBodyJson();
    }

    public function getHttpCode() {
        return $this->httpCode;
    }

    public function getResponseBody() {
        return $this->responseBody;
    }

    public function isResponseJson() {
        json_decode($this->responseBody);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function getResponseBodyJson() {
        return json_decode($this->responseBody);
    }

    public function getResponseTotalCount() {
        return $this->xTotalCount;
    }

    public function responseHadError() {
        return $this->responseHadError;
    }

}
