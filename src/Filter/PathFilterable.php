<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf\Filter;

interface PathFilterable
{
    /**
     * Appy path filters and return true if its ok or false 
     *
     * @param array $headers     
     * @throws Exception
     */
    public function applyPathFilters(array $headers);
}
