<head>
    <title><?php bloginfo('name'); ?>
    <?php wp_title(); ?>
</title>
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
   