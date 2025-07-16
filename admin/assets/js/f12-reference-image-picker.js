jQuery(function ($) {
    /*
     * Select/Upload image(s) event
     */
    $('body').on('click', '.f12r_upload_image_button', function (e) {
        e.preventDefault();
        var output = $(this).attr("data-key-output");
        var id = $(this).attr("data-key-id");

        var attributes = {
            title: 'Insert image',
            library: {
                // uncomment the next line if you want to attach image to the current post
                //uploadedTo: wp.media.view.settings.post.id,
                type: 'image',
                filterable: 'all'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false // for multiple image selection set to true
        };

        attributes.states = new wp.media.controller.Library({
            multiple	:	attributes.multiple,
            title		:	attributes.title,
            priority	:	20,
            filterable	:	'all'
        });

        var button = $(this),
            custom_uploader = wp.media(attributes);

        custom_uploader.on('select', function () { // it also has "open" and "close" events
            //var attachment = custom_uploader.state().get('selection').first().toJSON();
            //$(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" />').next().val(attachment.id).next().show();
            /* if you sen multiple to true, here is some code for getting the image IDs*/
            var attachments = custom_uploader.state().get('selection'),
                attachment_ids = new Array(),
                i = 0;
            attachments.each(function (attachment) {
                $(button).parent().find(output).empty();
                $(button).parent().find(output).append('<div data-key="' + attachment["id"] + '">' +
                    '<img class="true_pre_image" src="' + attachment["changed"]["url"] + '" style="max-width:30%;display:block;" />' +
                    '<a href="#" class="f12r_remove_image_button">Bild entfernen</a>' +
                    '<input type="hidden" name="' + id + '" value="' + attachment["id"] + '"/>' +
                    '</div>'
                )
                ; //.next().val(attachment.id).next().show();
                attachment_ids[i] = attachment['id'];
                i++;
            });
        });
        custom_uploader.open();
    });

    /*
     * Remove image event
     */
    $('body').on('click', '.f12r_remove_image_button', function () {
        $(this).parent().remove();
        return false;
    });

});