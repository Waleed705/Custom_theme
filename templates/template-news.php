<?php
/**
 * Template Name: news
 */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/style.css">
    <title><?php the_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <?php get_header();
    ?>
    <div class="searchbar">
        <form action="" method="GET"> 
        <input type="text" placeholder="Search By Name" name="title" value="<?php echo isset($_GET['title']) ? htmlspecialchars($_GET['title']) : ''; ?>">
        <input type="submit" value="Search">
    </form>

    </div>
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
    $searchdata = ""; 
    if (isset($_GET['title']) && $_GET['title'] != "") {
        $searchdata = $_GET['title'];
    }
?>

        <?php
        $wpnew = array(
            'post_type' => 'news',
            'post_status' => 'publish',
            's'=>$searchdata
        );
        $newsquery = new WP_Query($wpnew);

        if ($newsquery->have_posts()) {
            while ($newsquery->have_posts()) {
                $newsquery->the_post();
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
    <?php 
            } }
    ?>
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