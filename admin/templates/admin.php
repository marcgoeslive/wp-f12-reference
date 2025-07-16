<div class="meta-page f12-page-settings">
    <h1>Referenzen Einstellungen</h1>

    <form action="<?php echo esc_url( admin_url( "admin-post.php" ) ); ?>" method="post"
          name="f12r_reference_settings">
        <input type="hidden" name="action" value="f12r_reference_settings_save">
        <div class="f12-panel">
            <div class="f12-panel__header">
                <h2>Darstellung</h2>
                <p>
                    Einstellung für die Darstellung der Kacheln.
                </p>
            </div>
            <div class="f12-panel__content">
                <table class="f12-table">
                    <tr>
                        <td class="label">
                            <label>Zitate - Standardbild</label>
                            <p>Legen Sie das Hintergrundbild für Zitate fest.</p>
                        </td>
                        <td>
                            <?php echo $args["reference-quote-default-image"];?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <input type="submit" name="f12r_reference_settings" value="Speichern"/>
    </form>
</div>