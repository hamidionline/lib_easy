Easy Library
============

Joomla library with useful PHP classes founded by [EasyJoomla.org](http://www.easyjoomla.org/).


Image
------
**Import:** `jimport('easy.image');`

### Resize
Automatic image resizing. Method checks if the image was already resized and decides if it is necesary to resize it or just read already resized image. Source image stays the same. Thunbnail will be stored in the same folder as original.

**Usage:** `echo EasyImage::resize($relativePath, $width, $height);`

**Example:** `<img src="<?php echo EasyImage::resize('images/logo.png', 200, 200) ?>" />`

**Returns:** `<img src="images/logo_w200xh200.png" />`
