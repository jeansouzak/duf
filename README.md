# Duf - PHP Download and Upload Files
Duf is a PHP package to download files from web/local and upload to other servers (Google Cloud Storage).

<p align="center">
    <img src=".github/duf.png?raw=true" width="55%">
<p>
    


- First package version: Download resources from web and local to upload to Google Cloud Storage ☑
- Second package version: Create Duffer to upload to Amazon S3 ☐

## Installing Duf

The recommended way to install Duf is through
[Composer](https://getcomposer.org/).

```bash
composer require jeansouzak/duf
```

## How it works:
```php

use JeanSouzaK\Duf\Duff;
use JeanSouzaK\Duf\Prepare\WebResource;

$duf = Duff::getInstance(Duff::GOOGLE_CLOUD_STORAGE, [
    'project_id' => 'storage-test-227305',
    'key_path' => '/home/env/storage-test-227305-8472347a39489.json'
]);

// - Chaining example -
$uploadResults = $duf->prepare([
    new WebResource('teste.png', 'https://dummyimage.com/600x400/000/fff')
])->download()->addBucket('meubucket666')->upload();


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
$duf->addBucket('meubucket666');

//Upload downloaded files to bucket and get results
$uploadResults = $duf->upload();

// Iterate results and get result path
echo '<pre>';
foreach ($uploadResults as $uploadResult) {    
    print_r($uploadResult);
    echo (string)$uploadResult.'<br/>';
}

```
## Duf will help you if you desire upload a local file as well:
```php

use JeanSouzaK\Duf\Duff;
use JeanSouzaK\Duf\Prepare\LocalResource;
use JeanSouzaK\Duf\Prepare\WebResource;

//Call factory to get google cloud storage duffer
$duf = Duff::getInstance(Duff::GOOGLE_CLOUD_STORAGE, [
    'project_id' => 'storage-test-227305',
    'key_path' => '/home/env/storage-test-227305-8472347a39489.json'
]);

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
$duf->addBucket('meubucket666');

//Upload downloaded files to bucket and get results
$fileResults = $duf->upload();

```
## Using filters:
```php

use JeanSouzaK\Duf\Duff;
use JeanSouzaK\Duf\Prepare\WebResource;
use JeanSouzaK\Duf\Filter\WebFileSizeFilter;
use JeanSouzaK\Duf\Filter\WebFileExtensionFilter;
use JeanSouzaK\Duf\Filter\LocalFileSizeFilter;
use JeanSouzaK\Duf\Filter\LocalFileExtensionFilter;

//Call Factory to get google cloud storage duffer instance
$duf = Duff::getInstance(Duff::GOOGLE_CLOUD_STORAGE, [
    'project_id' => 'storage-test-227305',
    'key_path' => '/home/env/storage-test-227305-8472347a39489.json'
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

//Prepare object name, url and filters
$duf->prepare([
    new WebResource('object_one.png', 'https://dummyimage.com/600x400/000/fff', [$webPngSizeFilter]),
    new WebResource('object_two.png', 'https://dummyimage.com/600x400/000/fff.gif', [$webAllowedExtensionFilter]),
    new WebResource('object_three.png', 'https://dummyimage.com/100x100/000/fff', [$webPngSizeFilter, $webAllowedExtensionFilter]),
    new LocalResource('imagem', '/home/test/images/test.jpg', [$localJpgSizeFilter]),
    new LocalResource('imagem', '/home/test/project/composer.json', [$localAllowedExtensionFilter]),  
]);

//Make download prepared files
$duf->download();

//Add google cloud storage bucket name
$duf->addBucket('meubucket666');

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

use JeanSouzaK\Duf\Filter\PathFilterable;
use JeanSouzaK\Duf\Filter\HeaderFilterable;
use JeanSouzaK\Duf\Filter\Filterable;

//Local files filter
class MyLocalFilter implements Filterable, PathFilterable 
{
     public function applyPathFilters(array $filePathInfo) 
     {
         //throw exception with message
     }
} 

//Web files filter
class MyWebFilter implements Filterable, HeaderFilterable
{
     public function applyHeaderFilter(array $fileHeadersInfo) 
     {
         //throw exception with message
     }
} 


```
