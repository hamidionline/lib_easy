Easy Library
============

Joomla library with useful PHP classes founded by [EasyJoomla.org](http://www.easyjoomla.org/).


Images
------
Import: `jimport('easy.image');`

Automatic resizing images on output, not on upload. Method checks if the image was already resized and decides if it is necesary to resize it or not. Source image stays the same.

### Usage

`EasyImage::resize($relativePath, $width, $height)`

### Example

`<img src="<?php echo EasyImage::resize('images/logo.png', 200, 200) ?>" />`

returns

`<img src="images/logo_w200xh200.png" />`
