<?php

//Upload een foto naar het mapje ./uploads
//Returnt false als er geen file geupload is of als er een error is
//Returnt het path van de foto als de upload geslaagd is.
function uploadFile() {
    try {

        if (
            !isset( $_FILES['upfile']['error'] ) ||
            is_array( $_FILES['upfile']['error'] )
        ) {
            throw new RuntimeException( "Uploaden mislukt" );
        }

        switch ( $_FILES['upfile']['error'] ) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return false;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException( 'Bestand te groot.' );
            default:
                throw new RuntimeException( 'Onbekende error.' );
        }

        if ( $_FILES['upfile']['size'] > 10000000 ) {
            throw new RuntimeException('Bestand te groot.');
        }

        $finfo = new finfo( FILEINFO_MIME_TYPE );
        if ( false === $ext = array_search(
                $finfo->file( $_FILES['upfile']['tmp_name'] ),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )) {
            throw new RuntimeException( 'Bestand is geen foto.' );
        }

        $filename = sha1_file( $_FILES['upfile']['tmp_name'] );
        if ( !move_uploaded_file(
             $_FILES['upfile']['tmp_name'],
             sprintf( '.\uploads\%s.%s',
                 $filename, $ext
             )
        )) {
            throw new RuntimeException( 'Uploaden mislukt.' );
        }

        return sprintf( '.\uploads\%s.%s', $filename, $ext );


    } catch ( RuntimeException $ex ) {
        global $UPLOAD_ERROR;
        $UPLOAD_ERROR = "Bestand uploaden mislukt: " . $ex->getMessage();
        return false;
    }
}

?>