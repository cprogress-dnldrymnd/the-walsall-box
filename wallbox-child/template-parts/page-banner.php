<?php
$image_url = get_the_post_thumbnail_url();

if (!is_front_page()) {
    ?>


    <section class="page-banner" style="background-image: url(<?= $image_url ?>);">
        <div class="qodef-m-inner">
            <div class="qodef-m-content qodef-content-grid ">
                <h1> <?php the_title() ?></h1>
            </div>
        </div>
    </section>

<?php } ?>