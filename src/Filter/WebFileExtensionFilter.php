<?php

namespace JeanSouzaK\Duf\Filter;

use JeanSouzaK\Duf\Exception\FileExtensionException;
use JeanSouzaK\Duf\Tool\ArrayTool;

class WebFileExtensionFilter implements Filterable, HeaderFilterable
{
    const PDF = ['application/pdf', 'pdf'];
    const GIF = ['image/gif', 'gif'];
    const MPEG = ['audio/mpeg', 'mpeg'];
    const OGG = ['audio/ogg', 'ogg'];
    const MP3 = ['audio/mp3', 'mp3'];
    const JPG = ['image/jpg', 'jpg'];
    const PNG = ['image/png', 'png'];
    const JPEG = ['image/jpeg', 'jpeg'];
    const DOC = ['application/msword', 'doc'];
    /**
     * Allowed formats
     *
     * @var array
     */
    private $formats;

    
    public function __construct($allowedExtensions)
    {        
        $this->formats = $allowedExtensions;        
    }
  

    public function applyHeaderFilter(array $headers) {
        if (!array_key_exists('Content-Type', $headers) && !array_key_exists('content-type', $headers)) {
            throw new \Exception('Invalid headers for FileExtension applyHeaderFilter');
        }
        $contentType = $headers['Content-Type'] ?? $headers['content-type'] ?? null;

        if ($contentType == null || count($contentType) == 0) {
            throw new \Exception('Missing or empty Content-Type on response header');
        }
        $fileExtension = $contentType[0];
        if (!ArrayTool::inArrayRecursive(strtolower($fileExtension), $this->formats)) {
            throw new FileExtensionException('Invalid file extension file: '.$fileExtension);
        }
    }  
    

    /**
     * Get allowed formats
     *
     * @return  array
     */ 
    public function getFormats()
    {
        return $this->formats;
    }

    /**
     * Set allowed formats
     *
     * @param  array  $formats  Allowed formats
     *
     * @return  self
     */ 
    public function setFormats(array $formats)
    {
        $this->formats = $formats;

        return $this;
    }
}
