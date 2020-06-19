<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Download;


class DownloadOptions
{
    const INDUCE_FROM_BOTH = 1;
    const INDUCE_FROM_URL = 2;
    const INDUCE_FROM_CONTENT_TYPE = 3;

    public function __construct()
    {
        $this->induceType = false;
        $this->induceMethod = self::INDUCE_FROM_BOTH;
    }
    /**
     * Duf tries read content / mime type from file headers and put (concat) with file name
     *
     * @var bool
     */
    private $induceType;

    /**
     * Duf can use file url or contentType header do induce file extensionm defaults to 
     * 
     * @var string
     */
    private $induceMethod;

    /**
     * 
     * 
     * @var array
     */
    private $authentication;

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

    /**
     * Get the value of authentication
     *
     * @return  array
     */ 
    public function getAuthentication()
    {
        return $this->authentication;
    }

    /**
     * Set the value of authentication
     *
     * @param  array  $authentication
     *
     * @return  self
     */ 
    public function setAuthentication(array $authentication)
    {
        $this->authentication = $authentication;

        return $this;
    }

    /**
     * Get duf can use file url or contentType header do induce file extensionm defaults to
     *
     * @return  string
     */ 
    public function getInduceMethod()
    {
        return $this->induceMethod;
    }

    /**
     * Set duf can use file url or contentType header do induce file extensionm defaults to
     *
     * @param  string  $induceMethod  Duf can use file url or contentType header do induce file extensionm defaults to
     *
     * @return  self
     */ 
    public function setInduceMethod(string $induceMethod)
    {
        $this->induceMethod = $induceMethod;

        return $this;
    }
}
