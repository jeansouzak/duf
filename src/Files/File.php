<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf\Files;

use JeanSouzaK\Duf\Files\Fileable;

class File implements Fileable
{
    const DOWNLOADED = 1;
    const ERROR = 0;
    const WAITING = -1;
    const FINISHED = 2;

    public function __construct()
    {
        $this->status = self::WAITING;        
    }



    /**
     * File name
     *
     * @var string
     */
    private $name;

    /**
     * Message if file throws error
     *
     * @var string
     */
    private $errorMessage;

    /**
     * File bytes
     * @var string
     */
    private $bytes;

    /**
     * Status of download
     *
     * @var int
     */
    private $status;

    /**
     * Result of whole process
     *
     * @var string
     */
    private $resultPath;


    /**
     * Boolean to check has error
     *
     * @var bool
     */
    private $hasError;



    /**
     * Get file bytes
     *
     * @return  string
     */
    public function getBytes()
    {
        return $this->bytes;
    }

    /**
     * Set file bytes
     *
     * @param  string  $bytes  File bytes
     *
     * @return  self
     */
    public function addBytes(string $bytes)
    {
        $this->bytes .= $bytes;

        return $this;
    }


    /**
     * Get status of download
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status of download
     *
     * @param  int  $status  Status of download
     *
     * @return  self
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
        if ($status == self::ERROR) {
            $this->hasError = true;
        }
        return $this;
    }

    /**
     * Get message if file throws error
     *
     * @return  string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Set message if file throws error
     *
     * @param  string  $errorMessage  Message if file throws error
     *
     * @return  self
     */
    public function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Get file name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set file name
     *
     * @param  string  $name  File name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get result of whole process
     *
     * @return  string
     */
    public function getResultPath()
    {
        return $this->resultPath;
    }

    /**
     * Set result of whole process
     *
     * @param  string  $resultPath  Result of whole process
     *
     * @return  self
     */
    public function setResultPath(string $resultPath)
    {
        $this->resultPath = $resultPath;

        return $this;
    }


    public function __toString()
    {
        return $this->status == self::FINISHED ? $this->resultPath : $this->errorMessage;
    }

    /**
     * Get boolean to check has error
     *
     * @return  bool
     */
    public function hasError()
    {
        return $this->hasError;
    }

    /**
     * Set boolean to check has error
     *
     * @param  bool  $hasError  Boolean to check has error
     *
     * @return  self
     */
    public function setHasError(bool $hasError)
    {
        $this->hasError = $hasError;

        return $this;
    }
}
