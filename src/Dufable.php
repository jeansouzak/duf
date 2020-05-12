<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf;

interface Dufable
{
    public function prepare(array $files, $token = '');

    public function download();

    public function upload();
}
