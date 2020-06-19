<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Download;

use GuzzleHttp\Client;
use JeanSouzaK\Duf\Prepare\WebResource;
use JeanSouzaK\Duf\Download\Intercepter;
use JeanSouzaK\Duf\Download\Intercepter\HttpIntercepter;

class HttpDownload implements Downloadable
{
    /**
     * Guzzle client
     *
     * @var Client
     */
    private $guzzleClient;

    /**
     * Undocumented variable
     *
     * @var WebResource
     */
    private $resource;

    /**
     * Undocumented variable
     *
     * @var Intercepter
     */
    private $httpIntercepter;

    public function __construct(WebResource $resource)
    {
        $this->guzzleClient = new Client();
        $this->resource = $resource;
        $this->httpIntercepter = new HttpIntercepter($this->resource);
    }
    
    public function download()
    {
        $headers = $this->resource->getDownloadOptions() ? $this->resource->getDownloadOptions()->getAuthentication() : [];
        $response = $this->guzzleClient->get($this->resource->getUrl(), [
            'headers' => $headers,
            'stream' => true
        ]);
        
        
        $this->httpIntercepter->interceptHeaderFilters($response);
        $this->httpIntercepter->induceFileExtension($response);

        return $response;
    }
}
