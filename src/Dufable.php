<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf;

use JeanSouzaK\Duf\Filter\Filterable;

interface Dufable
{
    /**
     * receive resource list and prepare to download
     *
     * @param array $resources
     * @param string $token
     * @return void
     */
    public function prepare(array $resources, $token = '');

    public function download();

    public function upload();

    public function addFilter(Filterable $filter);
}
