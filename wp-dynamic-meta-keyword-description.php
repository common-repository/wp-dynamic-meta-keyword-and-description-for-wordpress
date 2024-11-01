<?php
/*
Plugin Name: WP Dynamic Meta Keyword and Description
Plugin URI: http://nhanweb.com/
Description: Auto create keyword tag and description tag from tags and the excerpt or the content in the post.
Author: Nguyen Duy Nhan
Version: 1.0.0
Author URI: http://nhanweb.com
*/

function nhanweb_insert_meta(){

		if(is_single()){
			$id=intval($post->ID);
			$post = get_post($id);
			$t = wp_get_post_tags($post->ID);
			foreach($t as $k=>$tag){
				$tags[] = $tag->name;
			}
			
			$strtags = implode(",", $tags);
			
			if(trim($post->post_excerpt)!=""){
				$the_description = $post->post_excerpt;
			}else{
				$the_description = nhanweb_auto_exceprt(strip_tags($post->post_content), 160);
			}
			echo "<meta name=\"keywords\" content=\"".$strtags."\" />";
			echo "<meta name=\"description\" content=\"".$the_description."\" />";
		}
}

add_filter('wp_head', 'nhanweb_insert_meta');

if(!function_exists('nhanweb_auto_exceprt')){
				 
	function nhanweb_auto_exceprt($str, $limit) {
		if ($limit < strlen($str)) {
		$str = substr($str, 0, $limit);
		$strarr = explode(' ', $str);
		unset($strarr[count($strarr) - 1]);
		$str = implode(' ', $strarr);
		}
		return $str;
	}
}

?>