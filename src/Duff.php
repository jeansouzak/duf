<?php

namespace JeanSouzaK\Duf;

use JeanSouzaK\Duf\Duffer\GCSDuffer;
use JeanSouzaK\Duf\Duffer\GoogleStorageClientFactory;

class Duff
{

    const GOOGLE_CLOUD_STORAGE = GCSDuffer::class;

    /**     
     * @param string $service     
     * @return AbstractDuf
     */
    public static function getInstance($service, array $options = [])
    {
        switch ($service) {
            case self::GOOGLE_CLOUD_STORAGE:
                if (!(array_key_exists('project_id', $options) && array_key_exists('key_path', $options))) {
                    throw new \InvalidArgumentException('Invalid or not found arguments project_id and key_path');
                }
                $storageClient = GoogleStorageClientFactory::getInstance($options['project_id'], $options['key_path']);
                return new GCSDuffer($storageClient);
                break;
            default:
                throw new \Exception('Not implemented yet');
        }
    }
}
