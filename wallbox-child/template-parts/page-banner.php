<?php
if (!is_front_page() && is_page() && !is_page_template() || is_shop()) {

    if (is_shop()) {
        $title = 'SHOP';
        $image_url = wp_get_attachment_image_url(6397, 'large');
    } else {
        $title = get_the_title();
        $image_url = get_the_post_thumbnail_url();
    }
?>


    <section class="page-banner <?= $image_url ? 'with-background' : 'no-background' ?>" <?= $image_url ? 'style="background-image: url(' . $image_url . ')"' : '' ?>>
        <div class="qodef-m-inner">
            <div class="qodef-m-content qodef-content-grid ">
                <h1> <?= $title ?></h1>
            </div>
        </div>
    </section>

<?php } ?>