<?php

namespace ClimbingCard\Helpers\PostTypes;

use ClimbingCard\Helpers\PostTypes\Contracts\Registration;

class Crag implements Registration
{
	/**
	 *
	 */
	public function register()
	{
		$supports = [
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'custom-fields',
			'comments',
			'revisions',
			'post-formats',
			'page-attributes',
		];

		$labels = [
			'name' => _x('Crags', 'plural'),
			'singular_name' => _x('Crag', 'singular'),
			'menu_name' => _x('Crags', 'admin menu'),
			'name_admin_bar' => _x('Crags', 'admin bar'),
			'add_new' => _x('Add New', 'add new'),
			'add_new_item' => __('Add New crag'),
			'new_item' => __('New Crag'),
			'edit_item' => __('Edit Crag'),
			'view_item' => __('View Crag'),
			'all_items' => __('All Crags'),
			'search_items' => __('Search Crags'),
			'not_found' => __('No crags found.'),
		];

		$args = [
			'supports' => $supports,
			'labels' => $labels,
			'public' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'crags'),
			'has_archive' => false,
			'hierarchical' => true,
			'show_in_menu' => false,
		];

		register_post_type('crag', $args);
	}
}
