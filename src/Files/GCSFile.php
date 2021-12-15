<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf\Files;

use JeanSouzaK\Duf\Files\File;
use JeanSouzaK\Duf\Files\Fileable;

class GCSFile extends File implements Fileable{

    public function __construct(){
        parent::__construct();
    }

    /**
     * File ID on GCS
     *
     * @var string
     */
    private $id;

    /**
     * Link for file info
     *
     * @var string
     */
    private $selfLink;

    /**
     * Bucket name
     *
     * @var string
     */
    private $bucket;

    /**
     * File content-type
     *
     * @var string
     */
    private $contentType;

    /**
     * File size
     *
     * @var string
     */
    private $size;

    /**
     * File ID
     *
     * @var string
     */
    private $timeCreated;

    /**
     * Get file id
     *
     * @return  string
     */
    public function getId()
    {
        return $this->id;
    }

     /**
     * Set file id
     *
     * @return  string
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * Get files info selfLink
     *
     * @return  string
     */
    public function getSelfLink()
    {
        return $this->selfLink;
    }

    /**
     * Get files info selfLink
     *
     * @return  string
     */
    public function setSelfLink(string $selfLink)
    {
        $this->selfLink = $selfLink;
    }

    /**
     * Get files bucket name
     *
     * @return  string
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * Get files bucket name
     *
     * @return  string
     */
    public function setBucket(string $name)
    {
        $this->bucket = $bucket;
    }
}