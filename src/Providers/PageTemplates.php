<?php

namespace ClimbingCard\Providers;

use function ClimbingCard\views_path;
use function ClimbingCard\check_if_template_is_in_use;

class PageTemplates
{
    /**
     * The array of templates that this plugin tracks.
     * 
     * @type array
     */
    protected $templates;

    protected $templateName = 'cards/index.php';

    /**
     * Initialize registration of page templates.
     *
     * @return void
     */
    public function init()
    {

        $this->templates = [$this->templateName => __('Climbing Cards', 'climbing-card')];

        add_filter('theme_page_templates', [$this, 'addNewTemplate'], 10, 3);
        add_filter('wp_insert_post_data', [$this, 'registerProjectTemplates']);
        add_filter('template_include', [$this, 'viewProjectTemplate']);
    }

    /**
     * Adds our template to the page template dropdown.
     * Allow only one page to have this template active.
     *
     * @return array
     */
    public function addNewTemplate($templates, $theme, $post)
    {
        $templatePageId = check_if_template_is_in_use($this->templateName);

        if (!$templatePageId || (!empty($post) && $templatePageId === $post->ID)) {
            $templates = array_merge($templates, $this->templates);
        }

        return $templates;
    }

    /**
     * Adds our template to the pages cache in order to trick WordPress
     * into thinking the template file exists.
     * 
     * @return array
     */
    public function registerProjectTemplates($data)
    {
        // Create the key used for the themes cache
        $cache_key = 'page_templates-' . md5(get_theme_root() . '/' . get_stylesheet());

        // Retrieve the cache list. 
        // If it doesn't exist, or it's empty prepare an array
        $templates = wp_get_theme()->get_page_templates();

        if (empty($templates)) {
            $templates = [];
        }

        // New cache, therefore remove the old one
        wp_cache_delete($cache_key, 'themes');

        // Now add our template to the list of templates by merging our templates
        // with the existing templates array from the cache.
        $templates = array_merge($templates, $this->templates);

        // Add the modified cache to allow WordPress to pick it up for listing
        // available templates
        wp_cache_add($cache_key, $templates, 'themes', 1800);

        return $data;
    }

    /**
     * Checks if the our template is assigned to the page
     * 
     * @return string
     */
    public function viewProjectTemplate($template)
    {
        global $post;

        // Return template if post is empty
        if (!$post) {
            return $template;
        }

        // Return default template if we don't have a custom one defined
        if (!isset($this->templates[get_post_meta($post->ID, '_wp_page_template', true)])) {
            return $template;
        }

        $file = views_path() . get_post_meta($post->ID, '_wp_page_template', true);

        // Just to be safe, we check if the file exist first
        if (file_exists($file)) {
            return $file;
        }

        return $template;
    }
}
