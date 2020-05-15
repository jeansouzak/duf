<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf;

use GuzzleHttp\Client;
use JeanSouzaK\Duf\Prepare\FileResourceFactory;
use JeanSouzaK\Duf\Filter\Filterable;
use JeanSouzaK\Duf\Prepare\Resource;

abstract class AbstractDuf implements Dufable
{
    /**
     * Files to prepare
     * @var Resource[] $fileResources
     */
    protected $fileResources;

    /**
     * Files prepared and downloaded
     *
     * @var File[]
     */
    protected $downloadedFiles;


    /**
     * Files downloaed and prepared to upload
     *
     * @var File[]
     */
    protected $filesToUpload;

    /**
     *
     * @var Client
     */
    protected $client;

    /**
     * All errored files on apply filters / exceptions
     *
     * @var File[]
     */
    protected $erroredFiles;

    /**
     * File filters
     *
     * @var []
     */
    protected $filters;

    public function __construct()
    {
        $this->client = new Client();
        $this->downloadedFiles = [];
        $this->filesToUpload = [];
        $this->filters = [];
        $this->erroredFiles = [];
    }

    public function prepare(array $resources, $token = '')
    {
        /** @var Resource $resource */
        array_filter($resources, function ($resource) {
            if (!(is_string($resource->getName()) && !empty($resource->getUrl()) && filter_var($resource->getUrl(), FILTER_VALIDATE_URL))) {
                throw new \InvalidArgumentException('One or more files not contain a name, empty or invalid URL');
            }
        }, ARRAY_FILTER_USE_BOTH);
        $this->fileResources = FileResourceFactory::generateFilesResource($resources, $token);
        return $this;
    }

    /**
     * Download prepared files
     *
     * @return void
     */
    public function download()
    {
        /** @var Resource $fileResource */
        foreach ($this->fileResources as $fileResource) {
            $file = new File((string)$fileResource);
            try {
                $response = $this->client->get($fileResource->getUrl(), [
                    'headers' => [
                        $fileResource->getAuthentication()
                    ],
                    'stream' => true
                ]);
                
                $fileResource->processHeaderFilters($response->getHeaders());

                $body = $response->getBody();
                while (!$body->eof()) {
                    $file->addBytes($body->read(1024));
                }
            } catch (\Exception $e) {                
                $file->setStatus(File::ERROR);                
                $file->setErrorMessage($e->getMessage());                
            }
            
            $this->downloadedFiles[] = $file;
        }
        return $this;
    }


    public function upload()
    {   
        $this->filesToUpload = array_filter($this->downloadedFiles, function ($downloadedFile) {
            if($downloadedFile->getStatus() == File::ERROR) {
                $this->erroredFiles[] = $downloadedFile;
            } else {
                return $downloadedFile;
            }
            
        });
    }


    

    /**
     * Get $fileResources
     *
     * @return  []
     */
    public function getFileResources()
    {
        return $this->fileResources;
    }

    /**
     * Set $fileResources
     *
     * @param  []  $fileResources  $fileResources
     *
     * @return  self
     */
    public function setFileResources($fileResources)
    {
        $this->fileResources = $fileResources;

        return $this;
    }

    /**
     * Get files prepared and downloaded
     *
     * @return  File[]
     */
    public function getDownloadedFiles()
    {
        return $this->downloadedFiles;
    }

    /**
     * Set files prepared and downloaded
     *
     * @param  File[]  $downloadedFiles  Files prepared and downloaded
     *
     * @return  self
     */
    public function setDownloadedFiles($downloadedFiles)
    {
        $this->downloadedFiles = $downloadedFiles;

        return $this;
    }

    /**
     * Get files downloaed and prepared to upload
     *
     * @return  File[]
     */
    public function getFilesToUpload()
    {
        return $this->filesToUpload;
    }

    /**
     * Set files downloaed and prepared to upload
     *
     * @param  File[]  $filesToUpload  Files downloaed and prepared to upload
     *
     * @return  self
     */
    public function setFilesToUpload($filesToUpload)
    {
        $this->filesToUpload = $filesToUpload;

        return $this;
    }

    /**
     * Get file filters
     *
     * @return  []
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set file filters
     *
     * @param  []  $filters  File filters
     *
     * @return  self
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    public function addFilter(Filterable $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * Get all errored files on apply filters / exceptions
     *
     * @return  File[]
     */ 
    public function getErroredFiles()
    {
        return $this->erroredFiles;
    }

    /**
     * Set all errored files on apply filters / exceptions
     *
     * @param  File[]  $erroredFiles  All errored files on apply filters / exceptions
     *
     * @return  self
     */ 
    public function setErroredFiles(array $erroredFiles)
    {
        $this->erroredFiles = $erroredFiles;

        return $this;
    }
}
