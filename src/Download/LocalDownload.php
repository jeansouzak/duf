<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Download;

use GuzzleHttp\Client;
use JeanSouzaK\Duf\Prepare\Resourceable;
use JeanSouzaK\Duf\Exception\FileNotFoundException;

class LocalDownload implements Downloadable
{
    public function download(Resourceable $resource)
    {
        if (!file_exists($resource->getUrl())) {
            throw new FileNotFoundException('File not found on path '.$resource->getUrl());
        }
        return file_get_contents($resource->getUrl());
    }
}
