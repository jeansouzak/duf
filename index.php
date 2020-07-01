<?php

require __DIR__ . '/vendor/autoload.php';

use JeanSouzaK\Duf\Download\DownloadOptions;
use JeanSouzaK\Duf\Duff;
use JeanSouzaK\Duf\Prepare\WebResource;
use JeanSouzaK\Duf\Filter\WebFileSizeFilter;
use JeanSouzaK\Duf\Filter\WebFileExtensionFilter;
use JeanSouzaK\Duf\Filter\LocalFileSizeFilter;
use JeanSouzaK\Duf\Filter\LocalFileExtensionFilter;
use JeanSouzaK\Duf\Filter\PathFilterable;
use JeanSouzaK\Duf\Filter\Filterable;
use JeanSouzaK\Duf\Filter\HeaderFilterable;
use JeanSouzaK\Duf\Prepare\LocalResource;

$duf = Duff::getInstance(Duff::GOOGLE_CLOUD_STORAGE, [
    'project_id' => 'mybucket-280818',
    'key_path' => './mybucket-280818-14d6f8d296cd.json'
]);

// - Chaining example -
$uploadResults = $duf->prepare([
    new WebResource('teste.png', 'https://dummyimage.com/600x400/000/fff')
])->download()->addBucket('dufbuckettest')->upload();


// - Step-by-step example -
//Prepare object name and url
$duf->prepare([
    new WebResource('object_one.png', 'https://dummyimage.com/600x400/000/fff'),
    new WebResource('object_two.png', 'https://dummyimage.com/300x200/000/fff'),
    new WebResource('object_three.png', 'https://dummyimage.com/100x100/000/fff')    
]);


//Make download prepared files
$duf->download();

//Add google cloud storage bucket name
$duf->addBucket('dufbuckettest');

//Upload downloaded files to bucket and get results
$uploadResults = $duf->upload();

// Iterate results and get result path
echo '<pre>';
foreach ($uploadResults as $uploadResult) {    
    print_r($uploadResult);
    echo (string)$uploadResult.'<br/>';
}


//Uploading from local file target
$duf->prepare([
    new LocalResource('imagem', '/home/test/images/test.jpg')    
]);

//You can mix local and remote target file
$duf->prepare([
    new LocalResource('imagem', '/home/test/images/test.jpg'),
    new WebResource('teste.png', 'https://dummyimage.com/600x400/000/fff')
]);

//Make download prepared files
$duf->download();

//Add google cloud storage bucket name
$duf->addBucket('dufbuckettest');

//Upload downloaded files to bucket and get results
$fileResults = $duf->upload();


//Call Factory to get google cloud storage duffer instance
$duf = Duff::getInstance(Duff::GOOGLE_CLOUD_STORAGE, [
    'project_id' => 'mybucket-280818',
    'key_path' => './mybucket-280818-14d6f8d296cd.json'
]);

//[WEB Filter] Configure a maximum file size to bind in a resource
$webPngSizeFilter = new WebFileSizeFilter(2, WebFileSizeFilter::MB);
//[WEB Filter] Configure alloweed extensions to bind in a resource
$webAllowedExtensionFilter = new WebFileExtensionFilter([
    WebFileExtensionFilter::JPEG,
    WebFileExtensionFilter::PNG    
]);

$localJpgSizeFilter = new LocalFileSizeFilter(1, 'M');
$localAllowedExtensionFilter = new LocalFileExtensionFilter([
    'json',
    'doc',
    'docx'
]);

$downloadOptions = new DownloadOptions();
$downloadOptions->setInduceType(true);

//Prepare object name, url and filters (second resource is a GIF contenttype not allowed format)
$duf->prepare([
    new WebResource('object_one.png', 'https://dummyimage.com/600x400/000/fff', [$webPngSizeFilter], $downloadOptions),
    new WebResource('object_two.png', 'https://dummyimage.com/600x400/000/fff.gif', [$webAllowedExtensionFilter]),
    new WebResource('object_three.png', 'https://dummyimage.com/100x100/000/fff', [$webPngSizeFilter, $webAllowedExtensionFilter]),
    new LocalResource('imagem', '/home/test/images/test.jpg', [$localJpgSizeFilter]),
    new LocalResource('imagem', '/home/test/project/composer.json', [$localAllowedExtensionFilter]),  
]);

//Create DownloadOptions(optional)
$downloadOptions = new DownloadOptions();
//Telling Duf to induce the file extension(default false)
$downloadOptions->setInduceType(true);
//Using file URL to induce file extension(defaul INDUCE_FROM_BOTH)
$downloadOptions->setInduceMethod(DownloadOptions::INDUCE_FROM_URL);

//Make download prepared files
$duf->download($downloadOptions);

//Add google cloud storage bucket name
$duf->addBucket('dufbuckettest');

//Upload downloaded files to bucket and get results
$fileResults = $duf->upload();

// Iterate results and get result path
foreach ($fileResults as $fileResult) {
    echo (string)$fileResult.'<br/>';
}
//You can dump result objects to see more details

//Working with result object:
/** @var File $fileResult */
foreach ($fileResults as $fileResult) {
    if($fileResult->hasError()){
        echo "File {$fileResult->getName()} contains error: {$fileResult->getErrorMessage()}<br/>";
        continue;
    }
    echo "File {$fileResult->getName()} uploaded sucessfull<br/>";
}

//Write your own filters
class MyLocalFilter implements Filterable, PathFilterable 
{
     public function applyPathFilters(array $filePathInfo) 
     {
         //throw exception with message
     }
} 

class MyWebFilter implements Filterable, HeaderFilterable
{
     public function applyHeaderFilter(array $fileHeadersInfo) 
     {
         //throw exception with message
     }
} 

