<?php
/**
 * Copyright 2019 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Jakiboy\paapi5\lib\api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Jakiboy\paapi5\inc\ApiException;
use Jakiboy\paapi5\inc\Configuration;
use Jakiboy\paapi5\inc\HeaderSelector;
use Jakiboy\paapi5\inc\ObjectSerializer;
use Jakiboy\paapi5\lib\SignHelper;
use http\Exception;

/**
 * DefaultApi Class Doc Comment
 *
 * @category Class
 * @package  Amazon\ProductAdvertisingAPI\v1
 * @author   Product Advertising API team
 */
class DefaultApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     */
    public function __construct(
        ClientInterface $client,
        Configuration $config,
        HeaderSelector $selector = null
    ) {
        $this->client = $client;
        $this->config = $config;
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation getBrowseNodes
     *
     * @param  \Jakiboy\paapi5\lib\GetBrowseNodesRequest $getBrowseNodesRequest GetBrowseNodesRequest (required)
     *
     * @throws \Jakiboy\paapi5\inc\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Jakiboy\paapi5\lib\GetBrowseNodesResponse
     */
    public function getBrowseNodes($getBrowseNodesRequest)
    {
        list($response) = $this->getBrowseNodesWithHttpInfo($getBrowseNodesRequest);
        return $response;
    }

    /**
     * Operation getBrowseNodesWithHttpInfo
     *
     * @param  \Jakiboy\paapi5\lib\GetBrowseNodesRequest $getBrowseNodesRequest GetBrowseNodesRequest (required)
     *
     * @throws \Jakiboy\paapi5\inc\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Jakiboy\paapi5\lib\GetBrowseNodesResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function getBrowseNodesWithHttpInfo($getBrowseNodesRequest)
    {
        $returnType = '\Jakiboy\paapi5\lib\GetBrowseNodesResponse';
        $request = $this->getBrowseNodesRequest($getBrowseNodesRequest);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            $responseBody = json_decode($e->getResponseBody());
            switch ($e->getCode()) {
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 429:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIServiceException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getBrowseNodesAsync
     *
     * 
     *
     * @param  \Jakiboy\paapi5\lib\GetBrowseNodesRequest $getBrowseNodesRequest GetBrowseNodesRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getBrowseNodesAsync($getBrowseNodesRequest)
    {
        return $this->getBrowseNodesAsyncWithHttpInfo($getBrowseNodesRequest)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getBrowseNodesAsyncWithHttpInfo
     *
     * 
     *
     * @param  \Jakiboy\paapi5\lib\GetBrowseNodesRequest $getBrowseNodesRequest GetBrowseNodesRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getBrowseNodesAsyncWithHttpInfo($getBrowseNodesRequest)
    {
        $returnType = '\Jakiboy\paapi5\lib\GetBrowseNodesResponse';
        $request = $this->getBrowseNodesRequest($getBrowseNodesRequest);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function (RequestException $exception) {
                    $apiException = new ApiException(
                        "[{$exception->getCode()}] {$exception->getMessage()}",
                        $exception->getCode(),
                        $exception->getResponse() ? $exception->getResponse()->getHeaders() : null,
                        $exception->getResponse() ? $exception->getResponse()->getBody()->getContents() : null
                    );
                    $data = ObjectSerializer::deserialize(
                        json_decode($apiException->getResponseBody()),
                        'Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $apiException->getResponseHeaders()
                    );
                    $apiException->setResponseObject($data);
                    throw $apiException;
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'getBrowseNodes'
     *
     * @param  \Jakiboy\paapi5\lib\GetBrowseNodesRequest $getBrowseNodesRequest GetBrowseNodesRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getBrowseNodesRequest($getBrowseNodesRequest)
    {
        // verify the required parameter 'getBrowseNodesRequest' is set
        if ($getBrowseNodesRequest === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $getBrowseNodesRequest when calling getBrowseNodes'
            );
        }

        $operation = 'GetBrowseNodes';
        $resourcePath = '/paapi5/getbrowsenodes';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // body params
        $_tempBody = null;
        if (isset($getBrowseNodesRequest)) {
            $_tempBody = $getBrowseNodesRequest;
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        $signHelper = new SignHelper($this->config, $httpBody->__toString(), $resourcePath, $operation);
        $headers = $signHelper->getHeaders();

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation getItems
     *
     * @param  \Jakiboy\paapi5\lib\GetItemsRequest $getItemsRequest GetItemsRequest (required)
     *
     * @throws \Jakiboy\paapi5\inc\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Jakiboy\paapi5\lib\GetItemsResponse
     */
    public function getItems($getItemsRequest)
    {
        list($response) = $this->getItemsWithHttpInfo($getItemsRequest);
        return $response;
    }

    /**
     * Operation getItemsWithHttpInfo
     *
     * @param  \Jakiboy\paapi5\lib\GetItemsRequest $getItemsRequest GetItemsRequest (required)
     *
     * @throws \Jakiboy\paapi5\inc\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Jakiboy\paapi5\lib\GetItemsResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function getItemsWithHttpInfo($getItemsRequest)
    {
        $returnType = '\Jakiboy\paapi5\lib\GetItemsResponse';
        $request = $this->getItemsRequest($getItemsRequest);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            $responseBody = json_decode($e->getResponseBody());
            switch ($e->getCode()) {
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        'Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 429:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIServiceException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getItemsAsync
     *
     * 
     *
     * @param  \Jakiboy\paapi5\lib\GetItemsRequest $getItemsRequest GetItemsRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getItemsAsync($getItemsRequest)
    {
        return $this->getItemsAsyncWithHttpInfo($getItemsRequest)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getItemsAsyncWithHttpInfo
     *
     * 
     *
     * @param  \Jakiboy\paapi5\lib\GetItemsRequest $getItemsRequest GetItemsRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getItemsAsyncWithHttpInfo($getItemsRequest)
    {
        $returnType = '\Jakiboy\paapi5\lib\GetItemsResponse';
        $request = $this->getItemsRequest($getItemsRequest);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function (RequestException $exception) {
                    $apiException = new ApiException(
                        "[{$exception->getCode()}] {$exception->getMessage()}",
                        $exception->getCode(),
                        $exception->getResponse() ? $exception->getResponse()->getHeaders() : null,
                        $exception->getResponse() ? $exception->getResponse()->getBody()->getContents() : null
                    );
                    $data = ObjectSerializer::deserialize(
                        json_decode($apiException->getResponseBody()),
                        'Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $apiException->getResponseHeaders()
                    );
                    $apiException->setResponseObject($data);
                    throw $apiException;
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'getItems'
     *
     * @param  \Jakiboy\paapi5\lib\GetItemsRequest $getItemsRequest GetItemsRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getItemsRequest($getItemsRequest)
    {
        // verify the required parameter 'getItemsRequest' is set
        if ($getItemsRequest === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $getItemsRequest when calling getItems'
            );
        }

        $operation = 'GetItems';
        $resourcePath = '/paapi5/getitems';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // body params
        $_tempBody = null;
        if (isset($getItemsRequest)) {
            $_tempBody = $getItemsRequest;
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        $signHelper = new SignHelper($this->config, $httpBody->__toString(), $resourcePath, $operation);
        $headers = $signHelper->getHeaders();

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation getVariations
     *
     * @param  \Jakiboy\paapi5\lib\GetVariationsRequest $getVariationsRequest GetVariationsRequest (required)
     *
     * @throws \Jakiboy\paapi5\inc\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Jakiboy\paapi5\lib\GetVariationsResponse
     */
    public function getVariations($getVariationsRequest)
    {
        list($response) = $this->getVariationsWithHttpInfo($getVariationsRequest);
        return $response;
    }

    /**
     * Operation getVariationsWithHttpInfo
     *
     * @param  \Jakiboy\paapi5\lib\GetVariationsRequest $getVariationsRequest GetVariationsRequest (required)
     *
     * @throws \Jakiboy\paapi5\inc\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Jakiboy\paapi5\lib\GetVariationsResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function getVariationsWithHttpInfo($getVariationsRequest)
    {
        $returnType = '\Jakiboy\paapi5\lib\GetVariationsResponse';
        $request = $this->getVariationsRequest($getVariationsRequest);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            $responseBody = json_decode($e->getResponseBody());
            switch ($e->getCode()) {
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 429:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIServiceException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getVariationsAsync
     *
     * 
     *
     * @param  \Jakiboy\paapi5\lib\GetVariationsRequest $getVariationsRequest GetVariationsRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getVariationsAsync($getVariationsRequest)
    {
        return $this->getVariationsAsyncWithHttpInfo($getVariationsRequest)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getVariationsAsyncWithHttpInfo
     *
     * 
     *
     * @param  \Jakiboy\paapi5\lib\GetVariationsRequest $getVariationsRequest GetVariationsRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getVariationsAsyncWithHttpInfo($getVariationsRequest)
    {
        $returnType = '\Jakiboy\paapi5\lib\GetVariationsResponse';
        $request = $this->getVariationsRequest($getVariationsRequest);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function (RequestException $exception) {
                    $apiException = new ApiException(
                        "[{$exception->getCode()}] {$exception->getMessage()}",
                        $exception->getCode(),
                        $exception->getResponse() ? $exception->getResponse()->getHeaders() : null,
                        $exception->getResponse() ? $exception->getResponse()->getBody()->getContents() : null
                    );
                    $data = ObjectSerializer::deserialize(
                        json_decode($apiException->getResponseBody()),
                        'Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $apiException->getResponseHeaders()
                    );
                    $apiException->setResponseObject($data);
                    throw $apiException;
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'getVariations'
     *
     * @param  \Jakiboy\paapi5\lib\GetVariationsRequest $getVariationsRequest GetVariationsRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getVariationsRequest($getVariationsRequest)
    {
        // verify the required parameter 'getVariationsRequest' is set
        if ($getVariationsRequest === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $getVariationsRequest when calling getVariations'
            );
        }

        $operation = 'GetVariations';
        $resourcePath = '/paapi5/getvariations';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // body params
        $_tempBody = null;
        if (isset($getVariationsRequest)) {
            $_tempBody = $getVariationsRequest;
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        $signHelper = new SignHelper($this->config, $httpBody->__toString(), $resourcePath, $operation);
        $headers = $signHelper->getHeaders();

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation searchItems
     *
     * @param  \Jakiboy\paapi5\lib\SearchItemsRequest $searchItemsRequest SearchItemsRequest (required)
     *
     * @throws \Jakiboy\paapi5\inc\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Jakiboy\paapi5\lib\SearchItemsResponse
     */
    public function searchItems($searchItemsRequest)
    {
        list($response) = $this->searchItemsWithHttpInfo($searchItemsRequest);
        return $response;
    }

    /**
     * Operation searchItemsWithHttpInfo
     *
     * @param  \Jakiboy\paapi5\lib\SearchItemsRequest $searchItemsRequest SearchItemsRequest (required)
     *
     * @throws \Jakiboy\paapi5\inc\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Jakiboy\paapi5\lib\SearchItemsResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function searchItemsWithHttpInfo($searchItemsRequest)
    {
        $returnType = '\Jakiboy\paapi5\lib\SearchItemsResponse';
        $request = $this->searchItemsRequest($searchItemsRequest);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            $responseBody = json_decode($e->getResponseBody());
            switch ($e->getCode()) {
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 429:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = ObjectSerializer::deserialize(
                        $responseBody,
                        '\Jakiboy\paapi5\lib\ProductAdvertisingAPIServiceException',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation searchItemsAsync
     *
     * 
     *
     * @param  \Jakiboy\paapi5\lib\SearchItemsRequest $searchItemsRequest SearchItemsRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function searchItemsAsync($searchItemsRequest)
    {
        return $this->searchItemsAsyncWithHttpInfo($searchItemsRequest)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation searchItemsAsyncWithHttpInfo
     *
     * 
     *
     * @param  \Jakiboy\paapi5\lib\SearchItemsRequest $searchItemsRequest SearchItemsRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function searchItemsAsyncWithHttpInfo($searchItemsRequest)
    {
        $returnType = '\Jakiboy\paapi5\lib\SearchItemsResponse';
        $request = $this->searchItemsRequest($searchItemsRequest);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function (RequestException $exception) {
                    $apiException = new ApiException(
                        "[{$exception->getCode()}] {$exception->getMessage()}",
                        $exception->getCode(),
                        $exception->getResponse() ? $exception->getResponse()->getHeaders() : null,
                        $exception->getResponse() ? $exception->getResponse()->getBody()->getContents() : null
                    );
                    $data = ObjectSerializer::deserialize(
                        json_decode($apiException->getResponseBody()),
                        'Jakiboy\paapi5\lib\ProductAdvertisingAPIClientException',
                        $apiException->getResponseHeaders()
                    );
                    $apiException->setResponseObject($data);
                    throw $apiException;
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'searchItems'
     *
     * @param  \Jakiboy\paapi5\lib\SearchItemsRequest $searchItemsRequest SearchItemsRequest (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function searchItemsRequest($searchItemsRequest)
    {
        // verify the required parameter 'searchItemsRequest' is set
        if ($searchItemsRequest === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $searchItemsRequest when calling searchItems'
            );
        }

        $operation = 'SearchItems';
        $resourcePath = '/paapi5/searchitems';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // body params
        $_tempBody = null;
        if (isset($searchItemsRequest)) {
            $_tempBody = $searchItemsRequest;
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        $signHelper = new SignHelper($this->config, $httpBody->__toString(), $resourcePath, $operation);
        $headers = $signHelper->getHeaders();

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
