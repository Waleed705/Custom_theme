<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Waleed</title> -->
    <?php wp_head(); ?>
</head>
<body>
    <?php get_header(); ?>
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
                    $cat = get_categories(array('taxonomy'=>'category'));
                foreach($cat as $catvalue){
             ?>
                    <li><a href="<?php echo get_category_link($catvalue); ?>"><h3><?php echo $catvalue->name; ?></h3></a></li>
                    <?php } ?>
                </ul>
            </div>
            </div>
        </div>
        <div class="blog-posts-side">
            <?php
                while(have_posts()){
                    the_post();
            ?>
            <div class="blog-post">
                <div class="post-image">
                    <?php the_post_thumbnail(); ?>
                </div>
                <?php the_excerpt(); ?>
                <a href="<?php the_permalink(); ?>">Read more</a>
                <div class="post-heading">
                    <h1><?php the_title(); ?></h1>
                </div>
               <?php echo get_the_date(); ?>
            </div>
            <?php } ?>
            <?php wp_pagenavi(); ?>
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
<?php wp_footer(); ?>