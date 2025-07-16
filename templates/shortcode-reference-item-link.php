<!-- IMAGE HOVER BEGIN -->
<div class="f12-reference-ce-image-hover">
    <a href="<?php echo $args["link"]; ?>" title="Gehe zu <?php echo $args["title"]; ?>">
        <div class="f12-reference-ce-image-hover__image">
            <img src="<?php echo $args["image"]; ?>" alt="<?php echo $args["title"]; ?>">
            <span><?php echo $args["title"]; ?></span>
        </div>
        <div class="f12-reference-ce-image-hover__background"></div>
        <div class="f12-reference-ce-image-hover__content">
            <div class="f12-reference-ce-title">
                <h2>
					<?php echo $args["title"]; ?>
                </h2>
                <div class="f12-reference-divider"></div>
				<?php echo $args["text"]; ?>

	            <?php if ( ! empty( $args["terms"] ) ) : ?>
                    <div class="f12-reference-ce-terms">
			            <?php echo $args["terms"]; ?>
                    </div>
	            <?php endif; ?>
            </div>
        </div>
    </a>
</div>
<!-- IMAGE HOVER END -->