<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Prepare;

use JeanSouzaK\Duf\Download\DownloadOptions;
use JeanSouzaK\Duf\Download\HttpDownload;
use JeanSouzaK\Duf\Filter\HeaderFilterable;

class WebResource extends Resource
{

    public function download(DownloadOptions $options = null) 
    {
        $httpDownload = new HttpDownload();
        $induceType = $options && $options->getInduceType() ? true : false;
        return $httpDownload->download($this, $induceType);
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


    public function induceExtensionFromContentType($headersContentType) 
    {   
        $contentTypes = $headersContentType && count($headersContentType) > 0  ? explode('/', $headersContentType[0]) : [];
        $extensionType = count($contentTypes) > 1 ? '.'.$contentTypes[1] : '';
        $this->name .= $extensionType;        
    }

}
