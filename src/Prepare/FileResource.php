<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Prepare;

class FileResource
{

    /**
     * @var string
     */
    private $url;

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * Defined name
     *
     * @var string
     */
    private $name;

    /**
     * @var string $url
     * @var Authentication $authentication
     */
    public function __construct($name, $url, $authentication = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->authentication = $authentication;
    }

    

    /**
     * Get the value of url
     *
     * @return  string
     */ 
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the value of authentication
     *
     * @return  Authentication
     */ 
    public function getAuthentication()
    {
        return $this->authentication;
    }

    /**
     * Get defined name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set defined name
     *
     * @param  string  $name  Defined name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
