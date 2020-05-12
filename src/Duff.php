<?php

namespace JeanSouzaK\Duf;

use JeanSouzaK\Duf\Upload\GCSUpload;
use JeanSouzaK\Duf\Upload\GoogleStorageClientFactory;

class Duff
{

    const GOOGLE_CLOUD_STORE = GCSUpload::class;

    /**     
     * @param string $service     
     * @return DownloadUploadFile
     */
    public static function getInstance($service, array $options = [])
    {
        switch ($service) {
            case self::GOOGLE_CLOUD_STORE:
                if (!(array_key_exists('project_id', $options) && array_key_exists('key_path', $options))) {
                    throw new \InvalidArgumentException('Invalid or not found arguments project_id and key_path');
                }
                $storageClient = GoogleStorageClientFactory::getInstance($options['project_id'], $options['key_path']);
                return new GCSUpload($storageClient);
                break;
            default:
                throw new \Exception('Not implemented yet');
        }
    }
}
