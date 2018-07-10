/**
 * Admin JS codes.
 * 
 * @package WS Theme Addons.
 * 
 */

jQuery(document).ready(function($) {

    $("#ws-theme-addons-tabs").tabs({
            activate: function(event, ui) {
                var active = $('#tabs').tabs('option', 'active');

            }
        }

    );

});

//Show / Hide specific settings  :

// jQuery(document).ready(function($) {
//     if ($('#checkbox-enable-fb-widget').is(':checked')) {
//         $('.facebook-sub-options').show();
//     } else {
//         $('.facebook-sub-options').hide();
//     }
//     if ($('#checkbox-enable-twitter-widget').is(':checked')) {
//         $('.twitter-sub-options').show();
//     } else {
//         $('.twitter-sub-options').hide();
//     }
// });

jQuery('.wta-has-sub').change(function($) { //on change do stuff
    jQuery(this).parent('.switch').siblings('.sub-options').slideToggle(500, 'linear');
});

jQuery(document).on('click', '.ws-close-save-settings-notice', function(event) {

    event.preventDefault();

    jQuery(this).parent('#ws-theme-addons-settings_updated').hide();

});

/**
 * Importer Action AJAX CALLS.
 */

jQuery(function($) {
    jQuery(document).on('click', '.ws-theme-demo-import-submit', function(event) {
        event.preventDefault();
        var url = ws_theme_addons_admin.url;
        swal({
                title: ws_theme_addons_admin.strings.swal.title,
                text: ws_theme_addons_admin.strings.swal.text,
                icon: "warning",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        data: { 'action': 'ws-theme-addons-demo-import-action' }, // form data
                        type: 'POST', // POST
                        beforeSend: function(xhr) {

                            $('.ws-theme-demo-import-submit').hide();
                            $('#bod').show();
                            $('#bod-text').show();

                        },
                        success: function(data, status) {
                            // $('.ws-theme-demo-import-submit').text('Import Demo');
                            $('#bod').hide();
                            $('#bod-text').hide();
                            $('#response').html('<span class="success">Import Successful !! </span><a target="_blank"class="button button-primary"href="' + data.data["previewUrl"] + '">Visit Site</a>')
                        },
                        error: function(xhr, status, error) {
                            alert(status);
                        }
                    });
                } else {
                    swal(ws_theme_addons_admin.strings.swal.cancel_text);
                    return false;
                }
            });
    });

});