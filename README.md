Easy Library
============

Joomla library with useful PHP classes founded by [EasyJoomla.org](http://www.easyjoomla.org/).


Image
------
**Import:** `jimport('easy.image');`

### Resize
Automatic image resizing. Method checks if the image was already resized and decides if it is necesary to resize it or just read already resized image. Source image stays the same. Thunbnail will be stored in the same folder as original.

**Usage:** `echo EasyImage::resize($relativePath, $width, $height, $quantity);`
($height and $quantity are optional)

**Example:** `<img src="<?php echo EasyImage::resize('images/logo.png', 200, 200) ?>" />`

**Returns:** `<img src="images/logo_w200xh200.png" />`

### Upload
Safely upload an image.

**Usage:** `$imagePath = EasyFile::upload($formFieldName, $absolutPathToUploadFolder);`

**Example:** `$imagePath = EasyFile::upload('imageInput', JPATH::ROOT.'/images/stories/');`

File
------
**Import:** `jimport('easy.file');`

### Upload
Safely upload a file.

**Usage:** `$filePath = EasyFile::upload($formFieldName, $absolutPathToUploadFolder, $allowedFileExtensions);`

**Example:** `$filePath = EasyFile::upload('fileInput', JPATH::ROOT.'/images/stories/', array('jpg', 'png'));`


