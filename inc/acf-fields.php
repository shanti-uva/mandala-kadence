<?php
if ( function_exists('acf_add_local_field_group') ) {

    acf_add_local_field_group(array(
        'key' => 'group_subsite_settings',
        'title' => 'Subsite Settings',
        'fields' => array(

            array(
                'key' => 'field_use_short_codes',
                'label' => 'Use Short Codes',
                'name' => 'use_short_codes',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),

            array(
                'key' => 'field_subsite_menu',
                'label' => 'Subsite Menu',
                'name' => 'subsite_menu',
                'type' => 'text',
            ),

            array(
                'key' => 'field_subsite_title',
                'label' => 'Subsite Title',
                'name' => 'subsite_title',
                'type' => 'text',
            ),

            array(
                'key' => 'field_subsite_class',
                'label' => 'Subsite Class',
                'name' => 'subsite_class',
                'type' => 'text',
            ),

            array(
                'key' => 'field_subsite_logo',
                'label' => 'Subsite Logo',
                'name' => 'subsite_logo',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
            ),

            array(
                'key' => 'field_subsite_footer_menu',
                'label' => 'Subsite Footer Menu',
                'name' => 'subsite_footer_menu',
                'type' => 'text',
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'default',
                ),
            ),
        ),
    ));
}
