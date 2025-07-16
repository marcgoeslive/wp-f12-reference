<!-- COMPONENT IMAGE GRID BEGIN -->
<div class="f12-reference-wrapper">
    <div class="f12-reference-ce-image-grid">
		<?php
		if ( $args["f12r-reference-group-option-title"] == 1 ):
			?>
            <div class="f12-reference-ce-title">
                <h2>
					<?php echo $args["title"]; ?>
                </h2>
                <div class="f12-reference-divider"></div>
				<?php if ( isset( $args["description"] ) ): ?>
                    <p>
						<?php echo $args["description"]; ?>
                    </p>
				<?php endif; ?>
            </div>
		<?php endif; ?>
        <div class="f12-reference-ce-image-grid__items">
			<?php echo $args["items"]; ?>
        </div>
    </div>
</div>
<!-- COMPONENT IMAGE GRID END -->
