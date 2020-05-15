<?php

namespace JeanSouzaK\Duf\Filter;

use JeanSouzaK\Duf\Exception\FileSizeException;

class FileSizeFilter implements Filterable, HeaderFilterable
{
    const MB = 'M';
    const KB = 'K';
    const GB = 'G';
    
    /**
     * File size
     *
     * @var float
     */
    private $size;

    /**
     * Unity of size (mb, kb, gb)
     *
     * @var string
     */
    private $unity;
    /**
     *
     * @param float $size
     * @param string $unity
     */
    public function __construct($size, $unity)
    {
        $this->size = $this->sanitizeUnitySize($size, $unity);
        $this->unity = $unity;        
    }


    private function sanitizeUnitySize($bytes, $unity, $decimal_places = 1) {
        $formulas = [
            'K' => $bytes,
            'M' => $bytes * 1048576,
            'G' => $bytes * 1073741824
        ];
        if(!array_key_exists($unity, $formulas)) {
            throw new \Exception('Invalid unity size');
        }
        return $formulas[$unity];
    }
    

    /**
     * Get file size
     *
     * @return  float
     */ 
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set file size
     *
     * @param  float  $size  File size
     *
     * @return  self
     */ 
    public function setSize(float $size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get unity of size (mb, kb, gb)
     *
     * @return  string
     */ 
    public function getUnity()
    {
        return $this->unity;
    }

    /**
     * Set unity of size (mb, kb, gb)
     *
     * @param  string  $unity  Unity of size (mb, kb, gb)
     *
     * @return  self
     */ 
    public function setUnity(string $unity)
    {
        $this->unity = $unity;

        return $this;
    }

    public function applyHeaderFilter(array $headers) {        
        if(!array_key_exists('Content-Length', $headers) && count($headers['Content-Length']) > 0){
            throw new \Exception('Invalid headers for FileSize applyHeaderFilter');
        }
        $headerLength = $headers['Content-Length'][0];        
        if($headerLength > $this->size) {
            throw new FileSizeException('File exceeds size limit passed by '.$this->size. 'kb confgured current file is '.$headerLength. ' kb');
        }
    }

    
}
