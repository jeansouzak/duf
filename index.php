<?php

require __DIR__ . '/vendor/autoload.php';

use JeanSouzaK\Duf\Duff;

$duf = Duff::getInstance(Duff::GOOGLE_CLOUD_STORE, [
    'project_id' => 'storage-test-227305',
    'key_path' => '/home/env/storage-test-227305-8472347a39489.json'
]);

// - One line example -
$results = $duf->prepare(['teste.png' => 'https://dummyimage.com/600x400/000/fff'])->download()->addBucket('meubucket666')->upload();


// - Step-by-step example -
//Prepare object name and url
$duf->prepare([
    'object_one.png' => 'https://dummyimage.com/600x400/000/fff',
    'object_two.png' => 'https://dummyimage.com/300x200/000/fff',
    'object_three.png' => 'https://dummyimage.com/100x100/000/fff'
]);

//Make download prepared files
$duf->download();

//Add google cloud storage bucket name
$duf->addBucket('meubucket666');

//Upload downloaded files to bucket and get results
$uploadResults = $duf->upload();

// Iterate results and get result path
foreach ($uploadResults as $uploadResult) {
    echo (string)$uploadResult;
}
