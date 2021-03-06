<?php
declare (strict_types = 1);

namespace JeanSouzaK\Duf\Duffer;

use Google\Cloud\Storage\StorageClient;
use JeanSouzaK\Duf\File;
use JeanSouzaK\Duf\DownloadUploadFile;
use JeanSouzaK\Duf\AbstractDuf;

class GCSDuffer extends AbstractDuf
{

    const STORAGE_URI = 'https://storage.googleapis.com/';

    /**    
     *
     * @var StorageClient
     */
    private $storageClient;

    /**
     * GCS bucket name
     *
     * @var string
     */
    private $bucketName;

    public function __construct(StorageClient $storageClient)
    {
        parent::__construct();
        $this->storageClient = $storageClient;
        $this->bucketName = '';
    }

    public function addBucket($bucketName)
    {
        $this->bucketName = $bucketName;
        return $this;
    }


    public function upload()
    {
        parent::upload();
        
        //All files errored/invalid to download
        if(count($this->filesToUpload) == 0 && count($this->erroredFiles) > 0) {
            return $this->erroredFiles;
        }
        if (!count($this->filesToUpload) > 0) {
            throw new \Exception('You should prepare and download valid resources before upload files');
        }
        if ($this->bucketName == '') {
            throw new \Exception('You should call addBucket and define your bucketName before upload files');
        }
        $bucket = $this->storageClient->bucket($this->bucketName);

        /**
         * @var File $fileToUpload
         */
        foreach ($this->filesToUpload as $fileToUpload) {
            try {
                $fileName = $fileToUpload->getName();
                $bucket->upload($fileToUpload->getBytes(), [
                    'name' => $fileName
                ]);
                $fileToUpload->setResultPath(self::STORAGE_URI . $this->bucketName . '/' . $fileName);
                $fileToUpload->setStatus(FILE::FINISHED);
            } catch (\Exception $e) {
                $fileToUpload->setErrorMessage($e->getMessage());
                $fileToUpload->setStatus(FILE::ERROR);
                throw $e;
            }
        }
        return array_merge_recursive($this->erroredFiles , $this->filesToUpload);
    }
}
