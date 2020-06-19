<?php

declare(strict_types=1);

namespace JeanSouzaK\Duf\Prepare;

use JeanSouzaK\Duf\Download\DownloadOptions;
use JeanSouzaK\Duf\Download\HttpDownload;

class WebResource extends Resource
{

    public function __construct($name, $url, $filters = [], DownloadOptions $downloadOptions = null)
    {
        parent::__construct($name, $url, $filters);
        $this->$downloadOptions = $downloadOptions;
    }

    /**
     * 
     * 
     * @var DownloadOptions
     */
    private $downloadOptions;

    public function download(DownloadOptions $options = null)
    {
        $this->downloadOptions = $this->downloadOptions ? $this->downloadOptions : $options;
        $httpDownload = new HttpDownload($this);
        return $httpDownload->download();
    }

    /**
     * Get the value of downloadOptions
     *
     * @return  DownloadOptions
     */ 
    public function getDownloadOptions()
    {
        return $this->downloadOptions;
    }

    /**
     * Set the value of downloadOptions
     *
     * @param  DownloadOptions  $downloadOptions
     *
     * @return  self
     */ 
    public function setDownloadOptions(DownloadOptions $downloadOptions)
    {
        $this->downloadOptions = $downloadOptions;

        return $this;
    }
}
