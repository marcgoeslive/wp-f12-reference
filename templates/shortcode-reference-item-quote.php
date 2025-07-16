<!-- IMAGE HOVER BEGIN -->
<div class="f12-reference-ce-image-hover">
    <div class="f12-reference-ce-image-hover__image">
        <img src="<?php echo $args["image"]; ?>" alt="<?php echo $args["title"]; ?>">
        <span><?php echo $args["title"]; ?></span>
    </div>
    <div class="f12-reference-ce-image-hover__content f12-reference-ce-image-hover__quote">
        <div class="f12-reference-ce-title">
            <p>
	            <?php echo $args["text"]; ?>
            </p>
            <p class="author">
	            <?php echo $args["author"]; ?>
            </p>

	        <?php if ( ! empty( $args["terms"] ) ) : ?>
                <div class="f12-reference-ce-terms">
			        <?php echo $args["terms"]; ?>
                </div>
	        <?php endif; ?>
        </div>
    </div>
</div>
<!-- IMAGE HOVER END -->
