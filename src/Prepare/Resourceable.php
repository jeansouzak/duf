<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf\Prepare;

use JeanSouzaK\Duf\Download\DownloadOptions;

interface Resourceable
{
    public function download(DownloadOptions $options = null);
}
