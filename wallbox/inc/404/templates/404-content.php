<div id="qodef-404-page">
    <?php if (esmee_is_installed('core')) { ?>
        <span class="qodef-404-subtitle"><?php echo esc_html($subtitle); ?></span>
    <?php } ?>

    <h2 class="qodef-404-title"><?php echo esc_html($title); ?></h2>

    <p class="qodef-404-text"><?php echo esc_html($text); ?></p>

    <div class="qodef-404-button">
        <?php
        $button_params = array(
            'link' => esc_url(home_url('/')),
            'text' => esc_html($button_text),
        );

        esmee_render_button_element($button_params);
        ?>
    </div>
</div>
