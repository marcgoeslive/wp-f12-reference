<?php echo $args["wp_nonce_field"]; ?>
<table class="f12-table">
    <tr>
        <td class="label" style="width:300px;">
            <label>Gruppe wählen</label>
        </td>
        <td>
            <select name="f12r-reference-group"><?php echo $args["f12r-reference-group"]; ?></select>
        </td>
    </tr>
    <tr>
        <td class="label">
            <label>Darstellung</label>
            <p>
                Legt fest, wie die Kachel dargestellt werden soll.
            </p>
        </td>
        <td>
            <input type="checkbox" name="f12r-reference-display-quote" data-key="f12r-reference-display-quote"
                   class="toggle-display" value="1" <?php if ( $args["f12r-reference-display-quote"] == 1 ) {
				echo "checked=\"checked\"";
			} ?>/> Als Zitat
            darstellen
        </td>
    </tr>
    <tr id="f12r-reference-display-quote" <?php if ( ! isset( $args["f12r-reference-display-quote"] ) || $args["f12r-reference-display-quote"] != 1 ) {
		echo "style=\"display:none;\"";
	} ?>>
        <td class="label">
            <label>Author</label>
            <p>
                Geben Sie den Author des Zitats an.
            </p>
        </td>
        <td>
            <input type="text" name="f12r-reference-quote-author"
                   value="<?php echo $args["f12r-reference-quote-author"]; ?>"/>
        </td>
    </tr>
    <tr>
        <td class="label">
            <label>Bild</label>
            <p>
                Das Bild wird als Hintergrund dargestellt. Wenn <strong>Zitat</strong> aktiviert wurde, wird ein
                Standarbild hinterlegt.
            </p>
        </td>
        <td>
			<?php
			echo $args["f12r-reference-image"];
			?>
        </td>
    </tr>
    <tr>
        <td class="label">
            <label>Text</label>
            <p>
                Der Text wird beim Mouse-Over dargestellt. Wenn <strong>Zitat</strong> aktiviert wurde, wird der Text
                direkt angezeigt.
            </p>
        </td>
        <td>
			<?php
			echo wp_editor( $args["f12r-reference-text"], "f12r-reference-text" );
			?>
        </td>
    </tr>
    <tr>
        <td class="label">
            <label>Link</label>
            <p>
                Die Seite auf den die Kachel verlinkt.
            </p>
        </td>
        <td>
            <select name="f12r-reference-link">
                <option value="-1">Bitte wählen</option>
				<?php echo $args["f12r-reference-link"]; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">
            <label>Position</label>
            <p>
                Die Position an der die Kachel dargestellt wird.
            </p>
        </td>
        <td>
            <input type="text" name="f12-sort"
                   value="<?php echo $args["f12-sort"]; ?>"/>
        </td>
    </tr>
</table>
<script type="text/javascript">
    jQuery(".toggle-display").on("click", function () {
        if (jQuery(this).attr("checked")) {
            jQuery("#" + jQuery(this).attr("data-key")).show();
        } else {
            jQuery("#" + jQuery(this).attr("data-key")).hide();
        }
    });
</script>