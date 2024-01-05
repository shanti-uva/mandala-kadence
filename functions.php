<?php

/* Class for admin settings for Mandala Kadence child theme */
require_once 'class-mandala-admin.php';

/* Class to extend kadence to allow for subsite banners, menus, etc. */
require_once 'class-mandala-kadence.php';

add_filter('upload_mimes', 'add_custom_upload_mimes');
function add_custom_upload_mimes($existing_mimes) {
    $existing_mimes['otf'] = 'application/x-font-otf';
    $existing_mimes['woff'] = 'application/x-font-woff';
    $existing_mimes['woff2'] = 'application/x-font-woff';
    $existing_mimes['ttf'] = 'application/x-font-ttf';
    $existing_mimes['svg'] = 'image/svg+xml';
    $existing_mimes['eot'] = 'application/vnd.ms-fontobject';
    return $existing_mimes;
}

/*
    Move this code into the mandala kadence class
\/* Add div with id for search box portal above nav menu sidebar *\/
add_filter('kadence_dynamic_sidebar_content', 'add_search_button_portal');

function add_search_button_portal($sidebar) {
    // Add close button Portal to Sidebar header
    $output = preg_replace('/<\/h2>/', '<div id="main-menu-close"></div></h2>', $sidebar, 1);
    // Add Search Box portal to top of sidebar
    $output = str_replace('class="menu-main-menu-container">', 'class="menu-main-menu-container"><div id="search-box-btns"></div>', $output);
    return $output . '<!-- End of Sidebar -->';
}*/
