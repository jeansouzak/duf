<?php
declare (strict_types = 1);

namespace JeanSouzaK\Duf\Prepare;


class FileResourceFactory
{
    /**
     *
     * @param string $fileURL
     * @param string $token
     * @return Resource
     */
    public static function generateFileResource($fileName, $fileURL, $filters = [], $token = '')
    {
        $authentication = null;
        if ($token) {
            $authentication = new Authentication();
            $authentication->buildBasicAuthenticationFromToken($token);
        }
        return new Resource($fileName, $fileURL, $filters, $authentication);
    }

    /**
     *
     * @param Resource[] $resources
     * @param string $token
     * @return Resource
     */
    public static function generateFilesResource(array $resources, $token = '')
    {
        $fileResources = [];
        foreach ($resources as $resource) {            
            $fileResources[] = self::generateFileResource($resource->getName(), $resource->getUrl(), $resource->getFilters(), $token);
        }
        return $fileResources;
    }
}
