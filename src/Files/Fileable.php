<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf\Files;

interface Fileable
{
    public function getName();

    public function getStatus();

    public function getResultPath();

    public function setResultPath(string $resultPath);

    public function hasError();

    public function setHasError(bool $hasError);
}
