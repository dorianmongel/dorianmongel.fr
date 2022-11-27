<?php 
    require 'vendor/autoload.php';
    require 'config.php';


    use League\CommonMark\CommonMarkConverter;
    $converter = new CommonMarkConverter([
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
    ]);


    // HTML 

    $content            = array();
    $content[]          = file_get_contents('themes/'.$config['theme'].'/template/header.html');

    $content[]          = '<div class="grid">';
    $scandir            = scan_dir_reverse("./posts");
    foreach($scandir as $fichier){
        if( $fichier != '.' && $fichier != '..' && $fichier != '.gitignore'){
            $post       = file_get_contents('./posts/' . $fichier);
            $content[]  = '<article><div class="content">';
            $content[]  = '<span class="date">' . date('d/m/Y', strtotime( substr($fichier,0, -3) )) . '</span>';
            $content[]  = $converter->convert($post);
            $content[]  = '</div></article>';
        }
    
    }
    $content[]          = '</div>';
    $content[]          = file_get_contents('themes/'.$config['theme'].'/template/footer.html');

    $html               = implode('', $content);
    unlink( 'index.html' );
    $file               = 'index.html';
    $fileopen           = (fopen("$file",'a'));
    fwrite($fileopen, $html );
    fclose($fileopen);



    // RSS
    $content            = array();
    $content[]          = '<?xml version="1.0" encoding="UTF-8" ?>';
    $content[]          = '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
    $content[]          = '<channel>';
    $content[]          = '<atom:link href="' . $config['url'] . '/rss.xml" rel="self" type="application/rss+xml" />';
    $content[]          = '<title>' . $config['title'] . '</title>';
    $content[]          = '<link>' . $config['url'] . '</link>';
    $content[]          = '<description>' . $config['description'] . '</description>';
    $scandir            = scan_dir_reverse("./posts");
    $postNb             = 0;
    foreach($scandir as $fichier){
        if( $fichier != '.' && $fichier != '..' && $fichier != '.gitignore'){
            $postNb++;
            $post       = file_get_contents('./posts/' . $fichier);
            $content[]  = '<item>';
            $content[]  = '<pubDate>' . date('D, d M Y', strtotime( substr($fichier,0, -3) )) . ' 00:00:00 GMT</pubDate>';
            $content[]  = '<guid isPermaLink="false">Item' . $postNb .'</guid>';

            $content[]  = '<description><![CDATA[' .  $converter->convert($post)  . ']]></description>';
            $content[]  = '</item>';
        }
    
    }
    $content[]          = '</channel>';
    $content[]          = '</rss>';

    $flux               = implode('', $content);
    unlink( 'rss.xml' );
    $file               = 'rss.xml';
    $fileopen           = (fopen("$file",'a'));
    fwrite($fileopen, $flux );
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

