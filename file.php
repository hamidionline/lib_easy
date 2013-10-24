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


/*
*	Class for handeling images
*
*	Import it if you need it this way: jimport('easy.file');
*/
Class EasyFile
{
	/*
	*	Method for safe uploading a file.
	*
	*	Example usage: $filePath = EasyFile::upload('fileInput', JPATH::ROOT.'/images/stories/', array('jpg', 'png'));
	*
	*	@param 	string 	name of the form field with file array
	*	@param 	string 	relative path to store the file into
	*	@param 	array 	allowed  file extension types
	*	@return string 	relative path to uploaded file
	*	@since 	1.0.1
	*/
    static function upload($fileFieldName, $uploadPath, $allowedExtensions = array())
    {
    	$input = JFactory::getApplication()->input;
    	$file = $input->files->get($fileFieldName);
    	$filePath = false;

		if(isset($file['name']) && $file['name'])
		{

			if ($file['error'] > 0) 
			{
				switch ($file['error']) 
				{
					case 1:
					JError::raiseWarning( 100, JText::_( 'FILE TO LARGE THAN PHP INI ALLOWS' ));
					return;

					case 2:
					JError::raiseWarning( 100, JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' ));
					return;

					case 3:
					JError::raiseWarning( 100, JText::_( 'ERROR PARTIAL UPLOAD' ));
					return;

					case 4:
					JError::raiseWarning( 100, JText::_( 'ERROR NO FILE' ));
					return;
				}
			}

			$file['name'] = strtolower(JFile::makeSafe($file['name']));
			$fileExtension = JFile::getExt($file['name']);
			$allowedMimeTypes = self::getMimeTypes($allowedExtensions);

			if(in_array($fileExtension, $allowedExtensions) && in_array($file['type'], $allowedMimeTypes))
			{
				$filePath = JPath::clean($uploadPath.'/'.$file['name']);

				if($uploadPath)
				{
					if(!JFolder::exists($uploadPath))
					{
						if(!JFile::copy($uploadPath))
						{
							JError::raiseWarning( 100, JText::_( 'COULD NOT CREATE FOLDER ').$uploadPath);
						}
					}
				} 
				else 
				{
					JError::raiseWarning( 100, JText::_( 'ABSOLUTE FILE PATH IS EMPTY. GO GO EASYUPDATE OPTIONS AN FILL IT IN.' ));
				}

				if( !JFile::upload( $file['tmp_name'], $filePath ) )
				{
					JError::raiseWarning( 100, JText::_( 'ERROR MOVING FILE' ));
				}
			}
			else
			{
				JError::raiseWarning( 100, JText::_( 'FILE "'.$file['name'].'" COULD NOT BE SAVED. WRONG FILE TYPE.' ));
			}
			
		}

		return $filePath;
    }

    /*
	*	Method returns array of mime types for file extensions.
	*
	*	Example usage: EasyFile::getMimeTypes(array('zip', 'png'));
	*
	*	@param 	array 	file extensions
	*	@return array 	mime types
	*	@since 	1.0.1
	*/
    static function getMimeTypes($fileExtensions)
    {

    	if(is_string($fileExtensions))
    	{
    		$fileExtensions = array($fileExtensions);
    	}

    	$mimeTypes = array();

    	foreach($fileExtensions as $fileExtension)
    	{
    		$fileExtension = strtolower(trim($fileExtension));

    		switch ($fileExtension) 
			{
				case 'avi':
				$mimeTypes[] = 'application/x-troff-msvideo';
				$mimeTypes[] = 'video/avi';
				$mimeTypes[] = 'video/msvideo';
				$mimeTypes[] = 'video/x-msvideo';
				break;

				case 'bmp':
				$mimeTypes[] = 'image/bmp';
				$mimeTypes[] = 'image/x-windows-bmp';
				break;

				case 'css':
				$mimeTypes[] = 'application/x-pointplus';
				$mimeTypes[] = 'text/css';
				break;

				case 'doc':
				$mimeTypes[] = 'application/msword';
				break;

				case 'dwf':
				$mimeTypes[] = 'drawing/x-dwf';
				$mimeTypes[] = 'model/vnd.dwf';
				break;

				case 'dwg':
				$mimeTypes[] = 'application/acad';
				$mimeTypes[] = 'image/vnd.dwg';
				$mimeTypes[] = 'image/x-dwg';
				break;

				case 'gif':
				$mimeTypes[] = 'image/gif';
				break;

				case 'gtar':
				$mimeTypes[] = 'application/x-gtar';
				break;

				case 'gz':
				$mimeTypes[] = 'application/x-compressed';
				$mimeTypes[] = 'application/x-gzip';
				break;

				case 'gzip':
				$mimeTypes[] = 'application/x-gzip';
				$mimeTypes[] = 'multipart/x-gzip';
				break;

				case 'htm':
				$mimeTypes[] = 'text/html';
				break;

				case 'html':
				$mimeTypes[] = 'text/html';
				break;

				case 'jpeg':
				$mimeTypes[] = 'image/jpeg';
				$mimeTypes[] = 'image/pjpeg';
				break;

				case 'jpg':
				$mimeTypes[] = 'image/jpeg';
				$mimeTypes[] = 'image/pjpeg';
				break;

				case 'js':
				$mimeTypes[] = 'application/x-javascript';
				$mimeTypes[] = 'application/javascript';
				$mimeTypes[] = 'application/ecmascript';
				$mimeTypes[] = 'text/javascript';
				$mimeTypes[] = 'text/ecmascript';
				break;

				case 'mid':
				$mimeTypes[] = 'application/x-midi';
				$mimeTypes[] = 'audio/midi';
				$mimeTypes[] = 'audio/x-mid';
				$mimeTypes[] = 'audio/x-midi';
				$mimeTypes[] = 'music/crescendo';
				$mimeTypes[] = 'x-music/x-midi';
				break;

				case 'midi':
				$mimeTypes[] = 'application/x-midi';
				$mimeTypes[] = 'audio/midi';
				$mimeTypes[] = 'audio/x-mid';
				$mimeTypes[] = 'audio/x-midi';
				$mimeTypes[] = 'music/crescendo';
				$mimeTypes[] = 'x-music/x-midi';
				break;

				case 'mov':
				$mimeTypes[] = 'video/quicktime';
				break;

				case 'mp3':
				$mimeTypes[] = 'audio/mpeg3';
				$mimeTypes[] = 'audio/x-mpeg-3';
				$mimeTypes[] = 'video/mpeg';
				$mimeTypes[] = 'video/x-mpeg';
				break;

				case 'png':
				$mimeTypes[] = 'image/png';
				break;

				case 'pps':
				$mimeTypes[] = 'application/mspowerpoint';
				$mimeTypes[] = 'application/vnd.ms-powerpoint';
				break;

				case 'ppt':
				$mimeTypes[] = 'application/mspowerpoint';
				$mimeTypes[] = 'application/powerpoint';
				$mimeTypes[] = 'application/vnd.ms-powerpoint';
				$mimeTypes[] = 'application/x-mspowerpoint';
				break;

				case 'psd':
				$mimeTypes[] = 'application/octet-stream';
				break;

				case 'svf':
				$mimeTypes[] = 'image/vnd.dwg';
				$mimeTypes[] = 'image/x-dwg';
				break;

				case 'txt':
				$mimeTypes[] = 'text/plain';
				break;

				case 'xml':
				$mimeTypes[] = 'application/xml';
				$mimeTypes[] = 'text/xml';
				break;

				case 'zip':
				$mimeTypes[] = 'application/x-compressed';
				$mimeTypes[] = 'application/x-zip-compressed';
				$mimeTypes[] = 'application/octet-stream';
				$mimeTypes[] = 'application/zip';
				$mimeTypes[] = 'multipart/x-zip';
				break;
			}
    	}

    	return $mimeTypes;
    }
}