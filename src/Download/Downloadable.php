<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf\Download;

use JeanSouzaK\Duf\Prepare\Resourceable;

interface Downloadable
{
    public function download();
}
