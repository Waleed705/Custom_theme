<head>
    <title><?php bloginfo('name'); ?>
    <?php wp_title(); ?>
</title>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/style.css">
</head>
<header>
        <div class="logo">
            <?php
            $logoimg= get_header_image();
            ?>
           <a href="<?php echo site_url(); ?>"> <img src="<?php echo $logoimg; ?>" alt=""></a>
        </div>
        <div class="page-links">
            <?php
                wp_nav_menu(
                    array('theme_location'=>'primary-menu','menu_class'=>'nav')
                );
            ?>
        </div>
    </header>