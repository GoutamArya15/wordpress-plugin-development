jQuery(document).ready(function($) {
    // Listen for the download button click
    $('.download-plugin-btn').on('click', function(e) {
        e.preventDefault();

        var pluginFolder = $(this).data('plugin-folder');

        // Show a loading indicator (optional)
        var button = $(this);
        button.prop('disabled', true).text('Downloading...');

        // Send AJAX request to download the plugin
        $.ajax({
            url: pluginDownload.ajax_url,
            method: 'POST',
            data: {
                action: 'download_plugin',
                nonce: pluginDownload.nonce,
                plugin_folder: pluginFolder
            },
            success: function(response) {
                if (response.success) {
                    // Trigger the download
                    window.location.href = response.data.url;

                    // Reset button text (optional)
                    button.prop('disabled', false).text('Download');
                } else {
                    // Show an error message
                    alert(response.data.message);
                }
            },
            error: function() {
                alert('There was an error while processing the request.');
            }
        });
    });
});
