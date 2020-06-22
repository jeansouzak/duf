<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Prepare;

use JeanSouzaK\Duf\Filter\HeaderFilterable;


abstract class Resource implements Resourceable
{

    /**
     * @var string
     */
    protected $url;

    /**
     * Defined name
     *
     * @var string
     */
    protected $name;


    /**
     * Filters to apply on download resource
     *
     * @var Filterable[]
     */
    protected $filters;

    /**
     * @var string $url
     */
    public function __construct($name, $url, $filters = [])
    {
        $this->name = $name;
        $this->url = $url;
        $this->filters = $filters;
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



   
    public function __toString()
    {
        return $this->name;
    }

}
