<?php

declare(strict_types=1);

namespace JeanSouzaK\Duf\Download\Intercepter;

use JeanSouzaK\Duf\Download\DownloadOptions;
use JeanSouzaK\Duf\Filter\HeaderFilterable;
use JeanSouzaK\Duf\Prepare\WebResource;
use Psr\Http\Message\ResponseInterface;

class HttpIntercepter implements HttpInterceptable
{
    /**
     * The resource from which HttpIntercepter will get informations of the file Duf downloaded to proccess
     * filters and induce it's extension
     *
     * @var WebResource
     */
    private $webResource;

    public function __construct(WebResource $webResource)
    {
        $this->webResource = $webResource;
    }

    public function interceptHeaderFilters(ResponseInterface $response)
    {
        $headers = $response->getHeaders();
        if (count($this->webResource->getFilters()) == 0) {
            return true;
        }
        $headerFilters = array_filter($this->webResource->getFilters(), function ($filter) {
            return $filter instanceof HeaderFilterable;
        });

        /** @var HeaderFilterable $headerFilter */
        foreach ($headerFilters as $headerFilter) {
            $headerFilter->applyHeaderFilter($headers);
        }

        return true;
    }

    public function induceFileExtension(ResponseInterface $response)
    {
        $downloadOptions = $this->webResource->getDownloadOptions();

        if (!$downloadOptions) {
            return;
        }

        if (!$downloadOptions->getInduceType()) {
            return;
        }

        switch ($downloadOptions->getInduceMethod()) {
            case DownloadOptions::INDUCE_FROM_URL:
                return $this->induceExtensionFromUrl($this->webResource->getUrl());
            case DownloadOptions::INDUCE_FROM_CONTENT_TYPE:
                return $this->induceExtensionFromContentType($response->getHeaders());
            default:
                if ($this->induceExtensionFromUrl($this->webResource->getUrl())) {
                    return true;
                }
                return $this->induceExtensionFromContentType($response->getHeaders());
        }
    }

    public function induceExtensionFromUrl($url)
    {
        $extension = pathinfo($url, PATHINFO_EXTENSION);
        $queryParamsDelimiter = strpos($extension, "?");

        if (!$extension) {
            return false;
        }

        if (!$queryParamsDelimiter) {
            $name = $this->webResouce->getName() . $extension;
            $this->webResouce->setName($name);
            return true;
        }

        $extension = substr($extension, 0, $queryParamsDelimiter);
        $name = $this->webResouce->getName() . $extension;
        $this->webResouce->setName($name);
        return true;
    }

    public function induceExtensionFromContentType($headersContentType)
    {
        $contentTypes = $headersContentType && count($headersContentType) > 0  ? explode('/', $headersContentType[0]) : [];
        $extensionType = count($contentTypes) > 1 ? '.' . $contentTypes[1] : '';
        $name = $this->webResouce->getName() . $extensionType;
        $this->webResouce->setName($name);
    }
}
