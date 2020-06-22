<?php

declare(strict_types=1);

namespace JeanSouzaK\Duf\Download\Intercepter;

use Psr\Http\Message\ResponseInterface;

interface HttpInterceptable
{
    public function interceptHeaderFilters(ResponseInterface $response);

    public function induceFileExtension(ResponseInterface $response);
}
