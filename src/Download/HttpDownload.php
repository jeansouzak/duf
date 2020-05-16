<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Download;

use GuzzleHttp\Client;
use JeanSouzaK\Duf\Prepare\Resourceable;

class HttpDownload implements Downloadable
{
    /**
     * Guzzle client
     *
     * @var Client
     */
    private $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new Client();
    }
    public function download(Resourceable $resource)
    {
        $headers = $resource->getAuthentication();
        $response = $this->guzzleClient->get($resource->getUrl(), [
            'headers' => $headers,
            'stream' => true
        ]);
        
        $resource->processHeaderFilters($response->getHeaders());

        return $response;
    }
}
