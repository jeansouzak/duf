<?php

declare(strict_types=1);

namespace JeanSouzaK\Duf\Download;

use JeanSouzaK\Duf\Prepare\Resourceable;
use JeanSouzaK\Duf\Exception\FileNotFoundException;

class LocalDownload implements Downloadable
{
    /**
     * The resource from which LocalDownload will get informations on where to search for the file and download it
     *
     * @var Resourceable
     */
    private $resource;

    public function __construct(Resourceable $resource)
    {
        $this->resource = $resource;
    }

    public function download()
    {
        if (!file_exists($this->resource->getUrl())) {
            throw new FileNotFoundException('File not found on path ' . $this->resource->getUrl());
        }
        return file_get_contents($this->resource->getUrl());
    }
}
