<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Prepare;

use JeanSouzaK\Duf\Filter\HeaderFilterable;

class Resource
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
     * Filters to apply on download resource
     *
     * @var Filterable[]
     */
    private $filters;

    /**
     * @var string $url
     * @var Authentication $authentication
     */
    public function __construct($name, $url, $filters = [], $authentication = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->filters = $filters;
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

     /**
     * Get filters to apply on download resource
     *
     * @return  Filterable[]
     */ 
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set filters to apply on download resource
     *
     * @param  Filterable[]  $filters  Filters to apply on download resource
     *
     * @return  self
     */ 
    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
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
        
        $headerFilters = array_filter($this->filters, function ($filter) {
            return $filter instanceof HeaderFilterable;
        });
                
        /** @var HeaderFilterable $headerFilter */
        foreach ($headerFilters as $headerFilter) {
            $headerFilter->applyHeaderFilter($headers);
        }
    }

    public function __toString()
    {
        return $this->name;
    }
}
