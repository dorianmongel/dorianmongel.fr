<?php 
    require 'vendor/autoload.php';
    use League\CommonMark\CommonMarkConverter;
    $converter = new CommonMarkConverter([
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
    ]);

    $content            = array();
    $content[]          = file_get_contents('./template/header.html');

    $content[]          = '<div class="grid">';
    $scandir            = scan_dir_reverse("./posts");
    foreach($scandir as $fichier){
        if( $fichier != '.' && $fichier != '..' && $fichier != '.gitignore'){
            $post       = file_get_contents('./posts/' . $fichier);
            $content[]  = '<article><div class="content">';
            $content[]  = '<h2>' . date('d/m/Y', strtotime( substr($fichier,0, -3) )) . '</h2>';
            $content[]  = $converter->convert($post);
            $content[]  = '</div></article>';
        }
    
    }
    $content[]          = '</div>';
    $content[]          = file_get_contents('./template/footer.html');

    $html               = implode('', $content);
    unlink( 'index.html' );
    $file               = 'index.html';
    $fileopen           = (fopen("$file",'a'));
    fwrite($fileopen, $html );
    fclose($fileopen);


    function scan_dir_reverse($dir) {
        $ignored = array('.', '..');
        $files = array();    
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = $file;
        }
        arsort($files);
        $files = array_keys($files);
        return ($files) ? $files : false;
    }