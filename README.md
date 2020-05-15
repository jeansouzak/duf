# Duf - PHP Download and Upload Files
Duf is a PHP package to download files from web and upload to other servers.

<p align="center">
    <img src=".github/duf.png?raw=true" width="55%">
<p>
    


- First package version: upload to Google Cloud Storage
## Installing Duf

The recommended way to install Duf is through
[Composer](https://getcomposer.org/).

```bash
composer require jeansouzak/duf
```

## How it works:
```php

use JeanSouzaK\Duf\Duff;
use JeanSouzaK\Duf\Prepare\Resource;

$duf = Duff::getInstance(Duff::GOOGLE_CLOUD_STORAGE, [
    'project_id' => 'storage-test-227305',
    'key_path' => '/home/env/storage-test-227305-8472347a39489.json'
]);

// - Chaining example -
$uploadResults = $duf->prepare([
    new Resource('teste.png', 'https://dummyimage.com/600x400/000/fff')
])->download()->addBucket('meubucket666')->upload();


// - Step-by-step example -
//Prepare object name and url
$duf->prepare([
    new Resource('object_one.png', 'https://dummyimage.com/600x400/000/fff'),
    new Resource('object_two.png', 'https://dummyimage.com/300x200/000/fff'),
    new Resource('object_three.png', 'https://dummyimage.com/100x100/000/fff')    
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

## Using filters:
```php

use JeanSouzaK\Duf\Duff;
use JeanSouzaK\Duf\Filter\FileSizeFilter;
use JeanSouzaK\Duf\Prepare\Resource;
use JeanSouzaK\Duf\Filter\FileExtensionFilter;

//Call Factory to get google cloud storage duffer instance
$duf = Duff::getInstance(Duff::GOOGLE_CLOUD_STORAGE, [
    'project_id' => 'storage-test-227305',
    'key_path' => '/home/env/storage-test-227305-8472347a39489.json'
]);

//Configure a maximum file size to bind in a resource
$pngSizeFilter = new FileSizeFilter(2, FileSizeFilter::MB);
//Configure alloweed extensions to bind in a resource
$allowedExtensionFilter = new FileExtensionFilter([
    FileExtensionFilter::JPEG,
    FileExtensionFilter::PNG    
]);

//Prepare object name, url and filters (second resource is a GIF contenttype not allowed format)
$duf->prepare([
    new Resource('object_one.png', 'https://dummyimage.com/600x400/000/fff', [$pngSizeFilter]),
    new Resource('object_two.png', 'https://dummyimage.com/600x400/000/fff.gif', [$allowedExtensionFilter]),
    new Resource('object_three.png', 'https://dummyimage.com/100x100/000/fff', [$pngSizeFilter, $allowedExtensionFilter])    
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
/**
 * Results:
 * Invalid file extension file: image/gif
 * https://storage.googleapis.com/meubucket666/object_one.png
 * https://storage.googleapis.com/meubucket666/object_three.png
 */
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
/**
 * Results:
 * File object_two.png contains error: Invalid file extension file: image/gif
 * File object_one.png uploaded sucessfull
 * File object_three.png uploaded sucessfull
 */

```
