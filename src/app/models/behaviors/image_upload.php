<?php

uses('folder');
uses('file');

class ImageUploadBehavior extends ModelBehavior{
    var $options = array(
        'required'		    => false,
		'directory'         => 'img/products',
		'allowed_mime' 	    => array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png'),
		'allowed_extension' => array('.jpg', '.jpeg', '.png', '.gif'),
		'allowed_size'	    => 1048576,
		'random_filename'   => true,
        'image' => array(
        	'create_thumb'    => true,
            'thumb_directory' => 'img/products/thumbs/',
            'thumb_width'     => 120,
            'thumb_height'    => 120,
            'create_max'      => true,
            'max_directory'   => 'img/products/max/',
            'max_width'       => 240,
            'max_height'      => 240
         )
    );

    /**
	 * Array of errors
	 */
	var $errors = array();

    var $__fields;

    function setup(&$model, $config = array()){
        $config_temp = array();

        foreach($config as $field => $options){
            // Check if given field exists
            if(!$model->hasField($field)){
                unset($config[$field]);
                unset($model->data[$model->name][$field]);

                continue;
            }

			if(substr($options['directory'], -1) != '/'){
                $options['directory'] = $options['directory'] . DS;
            }

            if(isset($options['image']['thumb_directory']) && substr($options['image']['thumb_directory'], -1) != '/'){
                $options['image']['thumb_directory'] = $options['image']['thumb_directory'] . DS;
            }

            if(isset($options['image']['max_directory']) && substr($options['image']['max_directory'], -1) != '/'){
                $options['image']['max_directory'] = $options['image']['max_directory'] . DS;
            }

            $config_temp[$field] = $options;
        }

        $this->__fields = $config_temp;
    }

    function beforeSave(&$model) {
        if(count($this->__fields) > 0) {
            foreach($this->__fields as $field => $options){
                // Check for model data whether has been set or not
                if(!isset($model->data[$model->name][$field])){
                    continue;
                }

                // Check the data if it's not an array
                if(isset($model->data) && !is_array($model->data[$model->name][$field])){
                    unset($model->data[$model->name][$field]);
                    continue;
                }

                // Check any error occur
                if($model->data[$model->name][$field]['error'] > 0){
                    // if error == 4 then we are not loading a file, so lets see if we want to delete it
                    if(!empty($model->data[$model->name][$field]['delete'])) {
                    	// lets delete the old images
                    	$current = $model->findById($model->data[$model->name][$field]['delete']);
                       	if(!empty($current[$model->name][$field])) {
                       		$this->removeImages($current[$model->name][$field], $options);
                       	}
                    	$model->data[$model->name][$field] = '';
                    } else {
                    	unset($model->data[$model->name][$field]);
                    }
                    continue;
                }

                // Create final save path

                if(!isset($options['random_filename']) || !$options['random_filename']) {
                    $saveAs = $options['directory'] . DS . $model->data[$model->name][$field]['name'];
                } else {
                    // Remove any file which did exist for this model
                    if(!empty($model->data[$model->name]['id'])) {
						$current = $model->findById($model->data[$model->name]['id']);

                        // lets delete the old images
                       	if(!empty($current[$model->name][$field])) {
                       		$this->removeImages($current[$model->name][$field], $options);
                       	}
                    }

                    if(!isset($options['random_filename']) || !$options['random_filename']) {
                    	$saveAs = WWW_ROOT . $options['directory'] . DS . $model->data[$model->name][$field]['name'];
                	} else {
	                    $uniqueFileName = sha1(uniqid(rand(), true));
	                    $extension = explode('.', $model->data[$model->name][$field]['name']);
	                    $saveAs    = WWW_ROOT . $options['directory'] . $uniqueFileName . '.' . $extension[count($extension)-1];
                    }
                }

                // Attempt to move uploaded file
                if(!move_uploaded_file($model->data[$model->name][$field]['tmp_name'], $saveAs)) {
                    unset($model->data[$model->name][$field]);
                    continue;
                }

                // Update model data
                $model->data[$model->name]['type'] = $model->data[$model->name][$field]['type'];
                $model->data[$model->name]['size'] = $model->data[$model->name][$field]['size'];
                $model->data[$model->name][$field] = basename($saveAs);

                // Generate the thumb
                if(isset($options['image']['create_thumb']) && $options['image']['create_thumb'] == true) {
                	$thumb = WWW_ROOT . $options['image']['thumb_directory'] . DS . $model->data[$model->name][$field];
                	$this->generateThumbnail($saveAs,  $thumb, array('w' => $options['image']['thumb_width'], 'h' => $options['image']['thumb_height']));
                }

                // Generate the max image
                if(isset($options['image']['create_max']) && $options['image']['create_max'] == true) {
                	$max = WWW_ROOT . $options['image']['max_directory'] . DS . $model->data[$model->name][$field];
                	$this->generateThumbnail($saveAs,  $max, array('w' => $options['image']['max_width'], 'h' => $options['image']['max_height']));
                }

            }
        }

        return true;
    }

    function beforeValidate(&$model)
    {
        foreach($this->__fields as $field => $options) {
            if(!empty($model->data[$model->name][$field]['type']) && !empty($options['allowed_mime'])) {
                // Check extensions
                if(count($options['allowed_extension']) > 0) {
                    $matches = 0;
                    foreach($options['allowed_extension'] as $extension){
                        if(strtolower(substr($model->data[$model->name][$field]['name'],-strlen($extension))) == $extension){
                            $matches++;
                        }
                    }

                    if($matches == 0) {
                        $allowed_ext = implode(', ', $options['allowed_extension']);
                        $model->invalidate($field, sprintf(__('Somente os formatos %s são permitidos.', true), $allowed_ext));
                        continue;
                    }
                }

                // Check mime
                if(count($options['allowed_mime']) > 0 && !in_array($model->data[$model->name][$field]['type'], $options['allowed_mime'])) {
                    $model->invalidate($field, __('Formato de arquivo inválido', true));
                    continue;
                }

                // Check the size
                if($model->data[$model->name][$field]['size'] > $options['allowed_size']) {
                    $total = $options['allowed_size'] / 1024;
                	$model->invalidate($field, sprintf(__('Esta imagem ultrapassa o tamanho máximo de ' .$total. 'k. Por favor escolha outra.', true), $options['allowed_size']));
                    continue;
                }
            }else{
                if(is_array($options['required'])) {
                	foreach ($options['required'] as $action => $required) {
                        $empty = false;

                		switch($action){
                            case 'add':
                                if($required == true && empty($mode->data[$model->name]['id'])){
                                    $empty = true;
                                    continue;
                                }
                                break;

                            case 'edit':
                                if($required == true && !empty($mode->data[$model->name]['id'])){
                                    $empty = true;
                                    continue;
                                }
                                break;
                        }

                        if($empty){
                            $model->invalidate($field, sprintf(__('%s é preciso.', true), Inflector::humanize($field)));
                            continue;
                        }
                	}
                } elseif($options['required'] == true) {
                    $model->invalidate($field, sprintf(__('%s é preciso.', true), Inflector::humanize($field)));
                    continue;
                }
            }
        }
    }

    function beforeDelete(&$model) {
        if(count($this->__fields) > 0){
            $model->read(null, $model->id);
            if (isset($model->data)) {
                foreach($this->__fields as $field => $options){
                    if(!empty($model->data[$model->name][$field])) {
                    	$this->removeImages($model->data[$model->name][$field], $options);
                    }
                }
            }
        }
        return true;
    }

    function removeImages($file, $options)
    {
    	$file_with_ext = WWW_ROOT . $options['directory'] . $file;
		if(file_exists($file_with_ext)) {
			unlink($file_with_ext);
		}

		// and check thumb directory too
		$file_with_ext = WWW_ROOT . $options['image']['thumb_directory'] . $file;
		if(file_exists($file_with_ext)) {
		 	unlink($file_with_ext);
		}

		// and the max
		$file_with_ext = WWW_ROOT . $options['image']['max_directory'] . $file;
		if(file_exists($file_with_ext)) {
		    unlink($file_with_ext);
		}
    }

    /**
	 * Will generate a thumbnail as defined by the presets (or by $_GET vars)
	 * and place it in the target. If display = true it will also output the
	 * thumbnail.
	 *
	 * @param string $source the location of the source image (may be relative or absolute)
	 * @param string $target the target directory and filename for the generated thumbnail
	 * @param array $presets any presets set
	 * @param bool $overwrite if the target should be overwritten
	 * @param bool $display if the image should be displayed
	 * @return bool Success?
	 * @author Alex McFadyen & Changes by Michael Houghton
	 */
	function generateThumbnail($source = null, $target = null, $presets = null, $overwrite = true, $display = false)
	{
		$target_dir = substr($target, 0, -(strpos(strrev($target),'/')));

		if($source == null OR $target == null){//check correct params are set
			$this->addError("Both source[$source] and target[$target] must be set");
			return false;/*
		}elseif(!is_file($source)){//check source is a file
			$this->addError("Source[$source] is not a valid file");
			return false;
		}elseif(in_array($this->ImageTypeToMIMEtype($source), $this->allowed_mime_types)){//and is of allowed type
			$this->addError("Source[$source] is not a valid file type");
			return false;*/
		}elseif(!is_writable($target_dir)){//check if target directory is writeable
			$this->addError("Can not write to target directory [$target_dir]");
			return false;
		}elseif(is_file($target) AND !$overwrite){//check if target is a file already and not ok to be over written
			$this->addError("Target[$target] exsists and overwrite is not true");
			return false;
		}elseif(is_file($target) AND !is_writable($target)){
			$this->addError("Can not overwrite Target[$target]");
			return false;
		}

		//load PhpThumb
		App::import('Vendor', 'phpthumb'.DS.'phpthumb'); //update to this when RC2
		//vendor('phpthumb'.DS.'phpthumb');

		$phpThumb = new phpThumb();

		//set presets
		$phpThumb->config_nohotlink_enabled = false;
		$phpThumb->config_nooffsitelink_enabled = false;
		$phpThumb->config_prefer_imagemagick = true;
		$phpThumb->config_output_format = 'jpeg';
		$phpThumb->config_error_die_on_error = true;
		$phpThumb->config_allow_src_above_docroot = true;

		//optionals
		if(isset($this->max_cache_size)) $phpThumb->config_cache_maxsize = $this->max_cache_size;

		//load in source image
		$phpThumb->setSourceFilename($source);

		// lets set the default parameters
		$this->presets = array();
		$this->presets['q'] = 95; 			// jpeg output Quality - this can't be 100, 95 is the highest
		$this->presets['zc'] = 0;			// Zoom Crop
		$this->presets['far'] = 0;			// Fixed Aspect Ratio
		$this->presets['aoe'] = 1;			// Allow Uutput Enlargment
		$this->presets['iar'] = 1;

		if(!empty($presets)) {
			foreach($presets as $key => $preset) {
				$this->presets[$key] = $preset;
			}
		}

		foreach($this->presets as $key => $value) {
			if(isset($_GET[$key])) {
				$phpThumb->setParameter($key, $_GET[$key]);
			} else {
				if($value !== null) {
					$phpThumb->setParameter($key, $value);
				}
			}
		}

		//create the thumbnail
		if($phpThumb->generateThumbnail()){
			if(!$phpThumb->RenderToFile($target)){
				$this->addError('Could not render file to: '.$target);
			}elseif($display==true){
				$phpThumb->OutputThumbnail();
				die();//not perfect, i know but it insures cake doenst add extra code after the image.
			}
		} else {
			$this->addError('could not generate thumbnail');
		}

        // Change thumb permission, on suphp environment apache will not able to read the image
        // if the user not giving it (at least) 664 permission
        chmod($target, 0644);

		// if we have any errors, remove any thumbnail that was generated and return false
		if(count($this->errors)>0){
			if(file_exists($target)){
				unlink($target);
			}
			return false;
		} else return true;
	}
}

?>
