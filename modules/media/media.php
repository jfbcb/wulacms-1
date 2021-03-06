<?php
defined('KISSGO') or exit ('No direct script access allowed');
bind('do_admin_layout', 'hook_for_do_admin_layout_media@hooks/do_admin_layout', 2);
bind('get_activity_log_type', 'hook_for_activity_types_media@hooks/do_admin_layout');
bind('on_init_rest_server', 'hook_for_init_rest_server@hooks/init_rest_server');
bind('get_custom_field_widgets', 'hook_custom_field_widgets_media@hooks/get_custom_field_widgets');
bind('get_acl_resource', 'filter_for_media_acl_resource@hooks/get_acl_resource');
bind('page_checkbox_options', 'page_checkbox_options_by_media@hooks/page_checkbox_options');
bind('before_save_page', 'before_save_page_by_media@hooks/page_checkbox_options');
bind('get_media_types', 'hook_for_media_types_media@hooks/do_admin_layout');
bind('on_dashboard_window_ready_scripts', 'hook_for_media_init_smarty_engine');
bind('alter_mimage_field_value', '&MimageFieldWidget', 1, 2);
bind('parse_mimage_field_value', '&MimageFieldWidget');
bind('after_load_page_fields', 'hook_for_media_after_load_page_fields@hooks/page_checkbox_options');
if (bcfg('thumbnail@media')) {
	bind('before_parse_url', function ($url) {
		if (extension_loaded('imagick') && preg_match('#^(.+)/(.+?)-([1-9]\d*)x([1-9]\d*)\.(png|jpeg|jpg|gif)$#i', $url, $ms)) {
			$save_path     = WEB_ROOT . $ms[0];
			$origin        = $ms[1] . '/' . $ms[2] . '.' . $ms[5];
			$target_width  = $ms[3];
			$target_height = $ms[4];
			$allowed       = $target_width . 'x' . $target_height;
			$alloweds      = explode(',', cfg('alloweds@media'));
			if (!in_array($allowed, $alloweds)) {
				return $url;
			}
			$orig_file = WEB_ROOT . $origin;
			if (is_file($orig_file)) {
				$image = new Imagick($orig_file);
				$image->thumbnailImage($target_width, $target_height, bcfg('bestfill@media'), true);
				if (!file_exists($orig_file)) {
					$image->writeImage($save_path);
				}
				$mime = $image->getImageMimeType();
				header('Content-Type: ' . $mime);
				echo $image->getImageBlob();
				exit();
			}
		}

		return $url;
	}, 2000);
}
function hook_for_media_init_smarty_engine($scripts) {
	$scripts .= 'KissCms.AjaxUploadURL="' . tourl('media/upload') . "\";\n";
	$scripts .= 'KissCms.MediaURL="' . the_media_src('') . "\";\n";

	return $scripts;
}

function get_media_type($ext) {
	static $types = false;
	if ($types === false) {
		$types = apply_filter('get_media_types', array());
	}
	$ext = strtolower(trim($ext, '.'));
	if (isset ($types [ $ext ])) {
		return $types [ $ext ] [0];
	}

	return 'unknown';
}

function get_media_type_list() {
	static $types = false;
	if ($types === false) {
		$types  = array('unknown' => '未知');
		$typesx = apply_filter('get_media_types', array());
		foreach ($typesx as $t) {
			$types [ $t [0] ] = $t [1];
		}
	}

	return $types;
}