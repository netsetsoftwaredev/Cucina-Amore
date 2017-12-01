<?php

function DPWP_add_row_actions( $actions ) {
	global $post;
	if(!current_user_can('edit_posts') || !is_admin())
		exit;
    $actions['duplicate'] = '<a href="?duplicate='.$post->ID.'" >duplicate</a>';
    return $actions;
}

function DPWP_action_duplicate(){
	if(!current_user_can('edit_posts') || !is_admin())
		exit;
	// get post data
	
	if(isset($_REQUEST['duplicate'])) {	
		$post_id = intval($_REQUEST['duplicate']);
		$postObj = get_post( $post_id );
		$post =  (array) $postObj;
		$author = get_current_user_id();
		$post['post_author'] = $author;
		// unset the post guid
		unset($post['ID']);
		unset($post['guid']);

		$duplicate_post_id = wp_insert_post( $post);
		if($duplicate_post_id){
			$post_type = $postObj->post_type;
		
			// get all meta data for the post
			$meta_data = get_post_meta($post_id);

			if($meta_data){
				foreach ($meta_data as $meta_key => $meta_value) {
					if(count($meta_value) == 1){
						$meta_value = $meta_value[0];
					}
					add_post_meta($duplicate_post_id,$meta_key,$meta_value);
				}
			}

			// get comments and add to the new post

			$comments = get_comments( array('post_id' => $post_id) );

			if($comments){
				foreach ($comments as $comment) {
					$comment =  (array) $comment;
					unset($comment['comment_ID']);
					$comment['comment_post_ID'] = $duplicate_post_id;
					wp_insert_comment($comment);
				}
			}
			$taxonomies = get_object_taxonomies($post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			
			if($taxonomies){
				foreach ($taxonomies as $taxonomy) {
				  $post_terms = wp_get_object_terms($duplicate_post_id, $taxonomy, array('fields' => 'slugs'));
				 
				  wp_set_object_terms($duplicate_post_id, $post_terms, $taxonomy, false);
				}
			}
			if($duplicate_post_id && $post_type == "post")
			{
				$redirect_url = admin_url( 'edit.php' );
				wp_redirect( $redirect_url );
				exit();
			}
			else if($duplicate_post_id )
			{
				$redirect_url = admin_url( "edit.php?post_type=$post_type" );
				wp_redirect( $redirect_url );
				exit();
			}
		}
	}
}

add_action('admin_init','DPWP_action_duplicate');

add_filter( 'post_row_actions', 'DPWP_add_row_actions', 10, 1 );

add_filter( 'page_row_actions', 'DPWP_add_row_actions', 10, 1 );