<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Prepare;

use JeanSouzaK\Duf\Download\LocalDownload;
use JeanSouzaK\Duf\Filter\PathFilterable;

class LocalResource extends Resource
{
    public function download()
    {
        $localDownload = new LocalDownload();
        return $localDownload->download($this);
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
