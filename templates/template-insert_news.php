<?php
/**
 * Template Name: insert-news
 */
get_header();
?>
<?php
    if(isset($_POST['savenews'])){
        $id= wp_insert_post(
            array(
                'post_type'=>'news',
                'post_status'=>'draft',
                'post_title'=>$_POST['ntitle'],
                'post_content'=>$_POST['ndescription']
            )
        );
    }


?>


<form action="" method="post" class="news-form"> 
    <div class="main-inputs">
    <h2 class="form-title">Insert News</h2>
    <div class="form-group">
        <label for="news-title">Title:</label>
        <input type="text" id="news-title" name="ntitle" placeholder="Enter title" required class="form-input">
    </div>
    <div class="form-group">
        <label for="news-description">Description:</label>
        <textarea id="news-description" name="ndescription" placeholder="Enter description" required class="form-textarea"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="form-submit" name="savenews">Submit</button>
    </div>
    </div>
</form>









<?php
get_footer();
?>