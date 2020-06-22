<?php

declare(strict_types=1);

namespace JeanSouzaK\Duf\Prepare;

use JeanSouzaK\Duf\Download\DownloadOptions;
use JeanSouzaK\Duf\Download\LocalDownload;
use JeanSouzaK\Duf\Filter\PathFilterable;

class LocalResource extends Resource
{
    public function download(DownloadOptions $options = null)
    {
        $localDownload = new LocalDownload($this);
        $induceType = $options && $options->getInduceType() ? true : false;
        return $localDownload->download($this, $induceType);
    }

    public function processPathFilters(array $headers)
    {
        if (count($this->filters) == 0) {
            return true;
        }
        $pathFilters = array_filter($this->filters, function ($filter) {
            return $filter instanceof PathFilterable;
        });

        /** @var HeaderFilterable $headerFilter */
        foreach ($pathFilters as $pathFilters) {
            $pathFilters->applyPathFilters($headers);
        }

        return true;
    }
}
