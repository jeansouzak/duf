<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Download;


class DownloadOptions
{
    public function __construct()
    {
        $this->induceType = false;
    }
    /**
     * Duf tries read content / mime type from file headers and put (concat) with file name
     *
     * @var bool
     */
    private $induceType;

    /**
     * Get duf tries read content / mime type from file headers and put (concat) with file name
     *
     * @return  bool
     */ 
    public function getInduceType()
    {
        return $this->induceType;
    }

    /**
     * Set duf tries read content / mime type from file headers and put (concat) with file name
     *
     * @param  bool  $induceType  Duf tries read content / mime type from file headers and put (concat) with file name
     *
     * @return  self
     */ 
    public function setInduceType(bool $induceType)
    {
        $this->induceType = $induceType;

        return $this;
    }
}
