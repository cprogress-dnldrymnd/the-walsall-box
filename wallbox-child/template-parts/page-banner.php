<?php
$image_url = get_the_post_thumbnail_url();
if (!is_front_page() && is_page() && !is_page_template()) {
?>


    <section class="page-banner <?= $image_url ? 'with-background' : 'no-background' ?>" <?= $image_url ? 'style="background-image: url(' . $image_url . ')"' : '' ?>>
        <div class="qodef-m-inner">
            <div class="qodef-m-content qodef-content-grid ">
                <h1> <?php the_title() ?></h1>
            </div>
        </div>
    </section>

<?php } ?>