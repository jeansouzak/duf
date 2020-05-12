<?php
declare (strict_types = 1);

namespace JeanSouzaK\Duf;

use GuzzleHttp\Client;
use JeanSouzaK\Duf\Prepare\FileResourceFactory;


abstract class DownloadUploadFile implements Dufable
{
    /**
     * Files to prepare
     * @var [] $fileResources
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

    public function __construct()
    {
        $this->client = new Client();
        $this->downloadedFiles = [];
        $this->filesToUpload = [];
    }

    /**     
     * Validate and prepare resources to download
     * @param array $files
     * @param string $token
     * @return DownUpFiles
     */
    public function prepare(array $files, $token = '')
    {
        array_filter($files, function($url, $fileName) {                
            if(!(is_string($fileName) && !empty($url) && filter_var($url, FILTER_VALIDATE_URL))) {
                throw new \InvalidArgumentException('One or more files not contain a name, empty or invalid URL');
            }
        }, ARRAY_FILTER_USE_BOTH);
        $this->fileResources = FileResourceFactory::generateFilesResource($files, $token);
        return $this;
    }

    /**
     * Download prepared files
     *
     * @return void
     */
    public function download()
    {
        foreach ($this->fileResources as $fileResource) {            
            $file = new File((string)$fileResource);
            try {

                $response = $this->client->get($fileResource->getUrl(), [
                    'headers' => [
                        $fileResource->getAuthentication()
                    ],
                    'stream' => true
                ]);

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
        $this->filesToUpload = array_filter($this->downloadedFiles, function($downloadedFile) {
            return $downloadedFile->getStatus() != File::ERROR;
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
}
