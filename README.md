Easy Library
============

Joomla library with useful PHP classes founded by [EasyJoomla.org](http://www.easyjoomla.org/).

Import library
--------------

`jimport('easy.easyimage');`

Images
------

Automatic resizing images on output, not on upload. Method checks if the image was already resized and decides if it is necesary to resize it or not. Source image stays the same.

`<img class="logo" src="<?php echo EasyImage::resizeImage('images/logo.png', 200, 200) ?>" />`

returns

`<img class="logo" src="images/logo_w200xh200.png" />`
