<?php

/**
 * Image Upload plugin
 */
use Shaarli\Plugin\PluginManager;
use Shaarli\Config\ConfigManager;


/**
 * Render image upload form in the link edition form.
 *
 * @param array $data - form data.
 *
 * @return array - Updated form data.
 */
function hook_image_upload_render_editlink($data)
{
    $html = file_get_contents(PluginManager::$PLUGINS_PATH . '/image_upload/image_upload_form.html');
    $data['edit_link_plugin'][] = $html;

    return $data;
}

/**
 * When link is saved, upload the image and add it to the description
 *
 * @param array $data - Link data
 * @param ConfigManager $conf
 *
 * @return array - Updated link data
 */
function hook_image_upload_save_link($data, $conf)
{
    // error_log(print_r( $data, true));
	
    // Check if an image has been uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        return $data;
    }
	
	if(!is_valid_image_file($_FILES['image']['tmp_name']))
	{
		// Not a valid image file
        return $data;
	}

    // Path where the image will be saved
	$imageDir = $conf->get('resource.data_dir') . '/images';
	
	// Check if the image upload folder already exists
    if (!file_exists($imageDir)) {
        // create that folder if it does not exist
        mkdir($imageDir, 0777, true);
    }
	
	// Create a unique file name for the uploaded image to avoid overwriting an image from another shaare.
    $randomFileName = $data['shorturl'] . '_' . $_FILES['image']['name'];

    // Move the uploaded file to the data directory
	$imgPath = $imageDir . '/' . $randomFileName;
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $imgPath)) {
        return $data;
    }

    // Add link to the uploaded image in the description
    $data['description'] = '![' . $_FILES['image']['name'] . '](' . getFullUrl($imgPath, $data['_BASE_PATH_']) . ")\n" . $data['description'];

    return $data;
}

/**
 * Use getimagesize to check if file is an image
 */
function is_valid_image_file($filePath) {
    $imageInfo = @getimagesize($filePath);

    // If getimagesize returns false, then the file is not a valid image
    if ($imageInfo === false) {
        return false;
    }
    return true;
}

function getFullUrl($relativePath, $basePath) {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";

    $hostname = $_SERVER['HTTP_HOST'];
    
    if(!empty($basePath)) {
        return $protocol . "://" . $hostname . "/" .trim($basePath, '/') . "/" . ltrim($relativePath, "/");    
    }

    return $protocol . "://" . $hostname . "/" . ltrim($relativePath, '/');
}





