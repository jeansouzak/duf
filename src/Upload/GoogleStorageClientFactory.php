<?php

namespace JeanSouzaK\Duf\Upload;

use Google\Cloud\Storage\StorageClient;

class GoogleStorageClientFactory
{

    /**     
     * @param string $jsonKey
     * @param string $projectID
     * @return StorageClient
     */
    public static function getInstance($projectID, $keyFile)
    {
        $storageClient = new StorageClient([
            'keyFilePath' => $keyFile,
            'projectId' => $projectID
        ]);

        return $storageClient;
    }
}
