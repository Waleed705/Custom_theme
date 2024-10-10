<?php
    register_nav_menus(
        array('primary-menu'=>'Top Menu')
    );
    add_theme_Support('post-thumbnails');
    add_theme_Support('custom-header');
    
    register_sidebar(
        array(
            'name'=>'Sidebar Location',
            'id'=>'sidebar'
        )
    );
    add_theme_support('custom-background');
?>