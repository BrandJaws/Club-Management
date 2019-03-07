<?php

trait NetworkController {

    private $client;

    private $stripInput = [
        'token'
    ];

    private $auth_token;

    private $response;

    public function put($url, $params = [])
    {
	    $url = 'api/'.$url;
        $params = $this->filterOptions($params);
        $this->response = $this->client->put($url, [
            'query' => $params
        ]);
        return $this;
    }

    public function delete($url, $params = [])
    {
	    $url = 'api/'.$url;
        $params = $this->filterOptions($params);
        $this->response = $this->client->delete($url, [
            'body' => $params
        ]);
        return $this;
    }

    public function get($url, $params = [])
    {
	    $url = 'api/'.$url;
        $params = $this->filterOptions($params);
        $this->response = $this->client->get($url, [
            'query' => $params
        ]);
        return $this;
    }

    public function post($url, $params = [], $files = [])
    {
	    $url = 'api/'.$url;
        $params = $this->filterOptions($params);
        if ($files && is_array($files) && ! empty($files)) {
            $data = $files;
            foreach ($params as $key => $value) {
                $data[] = [
                    'name' => $key,
                    'contents' => $value
                ];
            }
            $this->response = $this->client->post($url, [
                'multipart' => (array) $data
            ]);
        } else {
            $this->response = $this->client->post($url, [
                'body' => $params
            ]);
        }
        return $this;
    }

    public function filterOptions($params)
    {
        if (! is_null($this->auth_token)) {
            $params['auth_token'] = $this->auth_token;
        }
        if (isset($params['_token'])) {
            unset($params['_token']);
        }
        if (isset($params['_token'])) {
            unset($params['_token']);
        }
        if (isset($params['_method'])) {
            unset($params['_method']);
        }
        return $params;
    }

    public function response()
    {
        switch ($this->response->getStatusCode()) {
            case 401:
                throw new \App\Exceptions\AccessTokenExpiryException($this->getResponseBody(), $this->getResponseCode());
                break;
            case 405:
            case 400:
            case 422:
            case 412:
            case 404:
                throw new \App\Exceptions\InValidResponse($this->getResponseBody(), $this->getResponseCode());
                break;
            case 200:
                return $this->getResponseBody();
            default:
                throw new \App\Exceptions\ServerCrashException('Something went wrong on the server. Please try again later');
        }
    }

    public function getResponseBody()
    {
        
        Log::debug($this->response);
        $json = $this->response->json();
        return $json['response'];
    }

    public function getResponseCode()
    {
        $json = $this->response->json();
        return $json['code'];
    }
}
