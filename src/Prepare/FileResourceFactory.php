<?php
declare (strict_types = 1);

namespace JeanSouzaK\Duf\Prepare;

class FileResourceFactory
{
    /**
     *
     * @param string $fileURL
     * @param string $token
     * @return FileResource
     */
    public static function generateFileResource($fileName, $fileURL, $token = '')
    {
        $authentication = null;
        if ($token) {
            $authentication = new Authentication();
            $authentication->buildBasicAuthenticationFromToken($token);
        }
        return new FileResource($fileName, $fileURL, $authentication);
    }

    /**
     *
     * @param array $fileURLs
     * @param string $token
     * @return FileResource
     */
    public static function generateFilesResource(array $fileURLs, $token = '')
    {
        $fileResources = [];
        foreach ($fileURLs as $fileName => $fileURL) {            
            $fileResources[] = self::generateFileResource($fileName, $fileURL, $token);
        }
        return $fileResources;
    }
}
