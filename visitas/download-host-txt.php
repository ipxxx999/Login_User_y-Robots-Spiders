<?php
if (isset($_GET['download_txt'])) {
    $file_example = '../host.txt';
    if (file_exists($file_example)) {
        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename='.basename($file_example));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_example));
        ob_clean();
        flush();
        readfile($file_example);
        exit;
    }
    else {
        echo 'Archivo no disponible.';
    }
}