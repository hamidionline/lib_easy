<?php
/**
 * @package		easyupdate
 * @copyright	Copyright © EasyJoomla.org - All rights reserved.
 * @license		GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.path');
jimport('joomla.image');


/*
*	Class for handeling images
*
*	Import it if you need it this way: jimport('easy.image');
*/
Class EasyImage
{
	/*
	*	Method for autogeneratin resized images.
	*
	*	Example usage: EasyImage::resize($item->image, 200, 200);
	*
	*	@param 	string 	relative path to source image
	*	@param 	int 	width
	*	@param 	int 	height
	*   @param  int     quality
	*	@return string 	relative path to resized image
	*	@since 	1.0.0
	*/
	static function resize($relativePath, $width = null, $height = null, $quality = null)
	{
		$absolutPath = JPath::clean(JPATH_ROOT.'/'.$relativePath);

		if (!JFile::exists($absolutPath))
		{
			JError::raiseWarning( 100, 'Image Path "'.$relativePath.'" could not be saved. Only images can be uploaded as logo.' );
			return $relativePath;
		}

		if ($width || $height)
		{
			$imageExt = JFile::getExt($absolutPath);
			$imageName = preg_replace('/\.'.$imageExt.'$/', '', JFile::getName($absolutPath));
			$imageNameNew = $imageName.'_w'.$width.'xh'.$height;
			$relativePathNew = str_replace($imageName.'.'.$imageExt, $imageNameNew.'.'.$imageExt, $relativePath);
			$absolutPathNew = JPath::clean(JPATH_ROOT.'/'.$relativePathNew);
			

			if (JFile::exists($absolutPathNew))
			{
				$imageDateOrigin = filemtime($absolutPath);
				$imageDateThumb = filemtime($absolutPathNew);
				$clearCache = ($imageDateOrigin > $imageDateThumb);

				if($clearCache == false)
				{
					return $relativePathNew;
				}
			}

			$image = new JImage($absolutPath);
			$properties = JImage::getImageFileProperties($absolutPath);

			if($properties->width < $width && $properties->height < $height)
			{
				return $relativePath;
			}

			$resizedImage = $image->resize($width, $height, true);
			$mime = $properties->mime;
			$options = array();

			if ($mime == 'image/jpeg')
			{
				$type = IMAGETYPE_JPEG;

				/*
				* from 0 (worst quality, smaller file) to 100 (best quality, biggest file)
				*/
				if ($quality)
				{
					$options['quality'] = $quality;
				}
				else
				{
					$options['quality'] = 75;
				}
			}
			elseif ($mime = 'image/png')
			{
				$type = IMAGETYPE_PNG;

				/* 
				* Compression level: 0-9 or -1, where 0 is NO COMPRESSION at all,
				* 1 is FASTEST but produces larger files, 9 provides the best
				* compression (smallest files) but takes a long time to compress, and
				* -1 selects the default compiled into the zlib library.
				*/
				if ($quality)
				{
					$options['quality'] = $quality;
				}
				else
				{
					$options['quality'] = 6;
				}
			}
			elseif ($mime = 'image/gif')
			{
				$type = IMAGETYPE_GIF;
			}

			$resizedImage->toFile($absolutPathNew, $type, $options);

			return $relativePathNew;
		}
		
		return $relativePath;
	}

	/*
	*	Method for image upload.
	*
	*	Example usage: EasyImage::upload('logo', 200, 200);
	*
	*	@param 	string 	Input name of the image
	*	@param 	string 	Absolut path to upload folder
	*	@return string 	Absolut path to uploaded image
	*	@since 	1.0.1
	*/
	static function upload($imageInputName, $uploadPath)
	{
		jimport('easy.file');
		return EasyFile::upload($imageInputName, $uploadPath, array('jpg', 'jpeg', 'png', 'gif'));
	}
}