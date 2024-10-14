<?php
/**
 * Template Name: Contact-us
 */
?>
<?php
get_header();
wp_head();
?>
<div class="contact-main">
<div class="contact-container">
    <h1>Get in Touch</h1>
    <p>We’d love to hear from you! Whether you have a question, feedback, or just want to say hi, feel free to reach out.</p>


    <div class="contact-info">
        <h2>Contact Information</h2>
        <p><strong>Phone:</strong>+<?php the_field('phone',13); ?></p>
        <p><strong>Email:</strong> <a href="mailto:waleed4872248@gmail.com"><?php the_field('email',13); ?></a></p>
        <p><strong>Address:</strong><?php the_field('address',13); ?></p>
    </div>
    <div class="map">
        <h2>Our Location</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1364.7918580472047!2d74.1995362!3d31.4548889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzHCsDI3JzE3LjYiTiA3NMKwMTInMDcuNiJF!5e0!3m2!1sen!2s!4v1696838370893!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

    </div>
</div>
</div>
<?php
get_footer();
?>