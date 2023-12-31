<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Ajax Uploader</title>
    <link href="<?=FILEUPLOAD_PLUGIN_URL?>/uploader/examples/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=FILEUPLOAD_PLUGIN_URL?>/uploader/examples/assets/css/styles.css" rel="stylesheet">
  </head>
  <body>
      <div style="text-align:center;">
        <?php
		    echo "upload_max_filesize:".ini_get("upload_max_filesize");
			echo "<br>";
			echo "post_max_size:".ini_get("post_max_size");
			echo "<br>";
			echo "max_input_time:".ini_get("max_input_time");
		?>
       </div> 
      <div class="container">
        <div class="page-header">
          <h1>Simple Ajax Uploader in WP plugin</h1>
          <h3>Basic Example</h3>
        </div>
          <div class="row" style="padding-top:10px;">
            <div class="col-xs-2">
              <button id="uploadBtn" class="btn btn-large btn-primary">Choose File</button>
            </div>
            <div class="col-xs-10">
          <div id="progressOuter" class="progress progress-striped active" style="display:none;">
            <div id="progressBar" class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
            </div>
          </div>
            </div>
          </div>
          <div class="row" style="padding-top:10px;">
            <div class="col-xs-10">
              <div id="msgBox">
              </div>
            </div>
          </div>
      </div>

  <script src="<?=FILEUPLOAD_PLUGIN_URL?>/uploader/SimpleAjaxUploader.js"></script>
<script>
function escapeTags( str ) {
  return String( str )
           .replace( /&/g, '&amp;' )
           .replace( /"/g, '&quot;' )
           .replace( /'/g, '&#39;' )
           .replace( /</g, '&lt;' )
           .replace( />/g, '&gt;' );
}

window.onload = function() {

  var btn = document.getElementById('uploadBtn'),
      progressBar = document.getElementById('progressBar'),
      progressOuter = document.getElementById('progressOuter'),
      msgBox = document.getElementById('msgBox');

  var uploader = new ss.SimpleUpload({
        button: btn,
        url: '<?=FILEUPLOAD_PLUGIN_URL?>/uploader/examples/basic_example/file_upload.php',
        name: 'uploadfile',
        multipart: true,
        hoverClass: 'hover',
        focusClass: 'focus',
        responseType: 'json',
        startXHR: function() {
            progressOuter.style.display = 'block'; // make progress bar visible
            this.setProgressBar( progressBar );
        },
        onSubmit: function() {
            msgBox.innerHTML = ''; // empty the message box
            btn.innerHTML = 'Uploading...'; // change button text to "Uploading..."
          },
        onComplete: function( filename, response ) {
            btn.innerHTML = 'Choose Another File';
            progressOuter.style.display = 'none'; // hide progress bar when upload is completed

            if ( !response ) {
                msgBox.innerHTML = 'Unable to upload file';
                return;
            }

            if ( response.success === true ) {
                msgBox.innerHTML = '<strong>' + escapeTags( filename ) + '</strong>' + ' successfully uploaded.';

            } else {
                if ( response.msg )  {
                    msgBox.innerHTML = escapeTags( response.msg );

                } else {
                    msgBox.innerHTML = 'An error occurred and the upload failed.';
                }
            }
          },
        onError: function() {
            progressOuter.style.display = 'none';
            msgBox.innerHTML = 'Unable to upload file';
          }
	});
};
</script>
  </body>
</html>
