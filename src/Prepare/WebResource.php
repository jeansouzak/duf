<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Prepare;

use JeanSouzaK\Duf\Download\HttpDownload;
use JeanSouzaK\Duf\Filter\HeaderFilterable;

class WebResource extends Resource
{

    public function download() 
    {
        $httpDownload = new HttpDownload();
        return $httpDownload->download($this);
    }

     /**
     * Apply header filters
     *
     * @param array $headers
     * @return void
     * @throws Exception
     */
    public function processHeaderFilters($headers)
    {
        if(count($this->filters) == 0) {
            return true;
        }        
        $headerFilters = array_filter($this->filters, function ($filter) {
            return $filter instanceof HeaderFilterable;
        });
                
        /** @var HeaderFilterable $headerFilter */
        foreach ($headerFilters as $headerFilter) {
            $headerFilter->applyHeaderFilter($headers);
        }

        return true;
    }

}
