<?php 
require 'vendor/autoload.php';
use League\CommonMark\CommonMarkConverter;
$converter = new CommonMarkConverter([
    'html_input' => 'strip',
    'allow_unsafe_links' => false,
]);

$content[] = '<!DOCTYPE html>';
$content[] = '<html lang="fr">';
$content[] = '<head>';
$content[] = '    <meta charset="UTF-8">';
$content[] = '    <meta http-equiv="X-UA-Compatible" content="IE=edge">';
$content[] = '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
$content[] = '    <title>Hello !</title>';
$content[] = '    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lora">';
$content[] = '    <style>';
$content[] = '        html{ background: #FFFFFF }';
$content[] = '        body{ margin: 0; padding: 30px; font-family: "Lora", serif; }';
$content[] = '        *{ color: #151A1E; font-weight: normal; box-sizing: border-box;}';
$content[] = '        #hello{ margin-bottom: 30px; font-size: 25px;}';
$content[] = '        h1{ display: inline-block; font-size: 25px;}';
$content[] = '        h2{font-size: 20px; font-style: italic; text-align: right; }';

$content[] = '        ul{padding: 0; margin: 0;font-size: 15px; text-align: right;}';
$content[] = '        ul li{ display: inline-block; background: #FFF; margin: 15px 0 0 15px; padding: 10px; border-radius: 5px;}';
$content[] = '        article{ padding-bottom: 30px;  width: calc(100% / 3); max-width: 500px; }';
$content[] = '        article div.content{display: block; border-radius: 5px;overflow: hidden;  background: #F2F5F8;  padding: 20px 30px; font-size: 20px; }';

    
$content[] = '    </style>';


$content[] = '</head>';
$content[] = '<body>';
$content[] = '<div id="hello">Bonjour, je suis <h1>Dorian Mongel</h1>, vous pourrez me retrouver sur la toile sur <a href="https://twitter.com/dorianmongel">twitter</a>, <a href="https://www.instagram.com/dorianmongel/">instagram</a>, <a href="https://unsplash.com/@_dorian_">unsplash</a> ou <a href="https://www.linkedin.com/in/dorianmongel/">linkedin</a>. On peut également se voir autour d\'un café à l\'<strong><a href="https://www.hiboost.fr">agence hiboost</a></strong>.</div>';
$content[] = '<div class="grid">';

$scandir = scan_dir_reverse("./posts");
foreach($scandir as $fichier){
    if( $fichier != '.' && $fichier != '..'){

        $post = file_get_contents('./posts/' . $fichier);
        $content[] = '<article><div class="content">';
        $content[] = $converter->convert($post);
        $content[] = '</div></article>';
       
    }
 
}
$content[] = '</section>';

$content[] = '    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js" integrity="sha512-JRlcvSZAXT8+5SQQAvklXGJuxXTouyq8oIMaYERZQasB8SBDHZaUbeASsJWpk0UUrf89DP3/aefPPrlMR1h1yQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
$content[] = '    <script>';
$content[] = '    var msnry = new Masonry( ".grid", {itemSelector: "article", gutter: 30});';
$content[] = '    </script>';

$content[] = '</body>';
$content[] = '</html>';


$html = implode('', $content);
unlink( 'index.html' );
$file ="index.html";
$fileopen=(fopen("$file",'a'));
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