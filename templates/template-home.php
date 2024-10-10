<?php
/**
 * Template Name: home
 */

 $cat = get_categories(array('taxonomy'=>'category'));

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/style.css">
        <title>Waleed</title>
        <?php get_header(); ?>
</head>
<body>
    <div class="main-container">
        <div class="left-side">
            <div class="sidebar">
            <h1>Quick Links</h1>
                <?php get_sidebar(); ?>
            </div>
            <div class="course">
                <h1>Course</h1>
            <div class="sidebar-links">
                <ul>
            <?php
                foreach($cat as $catvalue){
             ?>
                    <li><a href="<?php echo get_category_link($catvalue); ?>"><h3><?php echo $catvalue->name; ?></h3></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        </div>
        <div class="posts-side">
            <div class="post">
                <img src="<?php echo get_template_directory_uri();?>/front.jpg" alt="">
            </div>
        </div>
        <div class="news">
            <div class="sidebar-links">
                <h1>News</h1>
                <ul>
                <?php
                    $newscat = get_terms(['taxonomy'=>'news_categories',
                        'parent'=>0
                ]);
                    foreach($newscat as $newscatdata){
                ?>
               <li> <a href="<?php echo get_category_link($newscatdata); ?>"><h3><?php echo $newscatdata->name ?></h3></a></li>

                <?php } ?>
            </ul>
        </div>
        </div>
    </div>
    <?php get_footer(); ?>
</body>
</html>