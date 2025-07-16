<?php $args["wp_nonce_field"]; ?>
<table class="f12-table">
    <tr>
        <th colspan="2">
			<?php echo __( "Optionen", "f12r_reference" ); ?>
        </th>
    </tr>
    <tr>
        <td class="label" style="width:300px;">
            <label>
				<?php echo __( "Titel anzeigen?", "f12r_reference" ); ?>
            </label>
            <p>
				<?php echo __( "Wenn aktiviert wird der Titel der Gruppe als Titel auf der Seite angezeigt.", "f12r_reference" ); ?>
            </p>
        </td>
        <td>
            <input type="checkbox" name="f12r-reference-group-option-title"
                   value="1" <?php if ( $args["f12r-reference-group-option-title"] == 1 ) {
				echo "checked=\"checked\"";
			} ?>>
            <label>
				<?php echo __( "Ja", "f12r_reference" ); ?>
            </label>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <label><?php echo __( "Beschreibung", "f12r_reference" ); ?></label>
            <p>
				<?php echo __( "Hinterlegen Sie eine Beschreibung für die Gruppe, diese wird zusammen mit dem Titel ausgegeben.", "f12r_reference" ); ?>
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
			<?php echo wp_editor( $args["f12r-reference-group-description"], "f12r-reference-group-description", array("media_buttons" => false, "editor_height"=>150) ); ?>
        </td>
    </tr>
    <tr>
        <td class="label">
            <label>
				<?php echo __( "Referenzen", "f12r_reference" ); ?>
            </label>
            <p>
				<?php echo __( "Fügen Sie weitere Referenzen hinzu.", "f12r_reference" ); ?>
            </p>
        </td>
        <td>
            <a href="post-new.php?post_type=f12r_reference&f12r-reference-group-id=<?php echo $args["f12r-reference-group-id"]; ?>"
               class="button">
				<?php echo __( "Neue Referenz erstellen", "f12r_reference" ); ?>
            </a>
        </td>
    </tr>
    <tr>
        <td colspan="2">
			<?php echo __( "Hinweis: Sie können die Referenzen durch das Ziehen der Zeilen umsortieren.", "f12r_reference" ); ?>
        </td>
    </tr>
</table>

<table class="wp-list-table widefat fixed striped posts ">
    <thead>
    <tr>
        <th scope="scole" style="width:160px;">
			<?php echo __( "Bild", "f12r_reference" ); ?>
        </th>
        <th scope="scole">
			<?php echo __( "Referenzen", "f12r_reference" ); ?>
        </th>
    </tr>
    </thead>
    <tbody class="f12-sortable">
	<?php
	if ( isset( $args["f12r-reference-group"] ) ):
		foreach ( $args["f12r-reference-group"] as $key => $value ) :
			$attachment = wp_get_attachment_image_src( $value[3] )[0];

			?>
            <tr id="<?php echo $value[0]; ?>">
                <td>
                    <img src="<?php echo $attachment; ?>">
                </td>
                <td>
                    <a
                            href="post.php?post=<?php echo $value[0]; ?>&amp;action=edit"
                            aria-label="„<?php echo $value[1]; ?>“ bearbeiten"><?php echo $value[1]; ?></a>
                    <br>
					<?php echo $value[2]; ?>
                    <div class="row-actions">
                        <span class="edit"><a
                                    href="post.php?post=<?php echo $value[0]; ?>&amp;action=edit"
                                    aria-label="„<?php echo $value[1]; ?>“ bearbeiten">Bearbeiten</a> | </span>
                        <span class="trash"><a
                                    href="<?php echo get_delete_post_link( $value[0] ); ?>&f12r-reference-group-id=<?php echo $args["f12r-reference-group-id"]; ?>"
                                    class="submitdelete"
                                    aria-label="„<?php echo $value[1]; ?>“ in den Papierkorb verschieben">In Papierkorb legen</a> | </span>
                    </div>
                </td>
            </tr>
		<?php
		endforeach;
	endif;
	?>
    </tbody>
</table>