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
$content[] = '        html{ background: #265B91 }';
$content[] = '        body{ margin: 0; padding: 30px; font-family: "Lora", serif; }';
$content[] = '        *{ font-size: 25px; color: #DCE3ED; font-weight: normal }';
$content[] = '        h1{ display: inline-block; }';
$content[] = '        div{ font-size: 80px }';
$content[] = '    </style>';
$content[] = '</head>';
$content[] = '<body>';
$content[] = '    Bonjour, je suis <h1>Dorian Mongel</h1>, vous pourrez me retrouver sur la toile sur <a href="https://twitter.com/dorianmongel">twitter</a>, <a href="https://www.instagram.com/dorianmongel/">instagram</a>, <a href="https://unsplash.com/@_dorian_">unsplash</a> ou <a href="https://www.linkedin.com/in/dorianmongel/">linkedin</a>.<br />
    On peut également se voir autour d\'un café à l\'<strong><a href="https://www.hiboost.fr">agence hiboost</a></strong>.';

$scandir = scandir("./posts");
foreach($scandir as $fichier){
    if( $fichier != '.' && $fichier != '..'){

        $post = file_get_contents('./posts/' . $fichier);
        $content[] = '<article>';
        $content[] = $converter->convert($post);
        $content[] = '</article>';
    }
 
}

$content[] = '</body>';
$content[] = '</html>';


$html = implode('', $content);
unlink( 'index.html' );
$file ="index.html";
$fileopen=(fopen("$file",'a'));
fwrite($fileopen, $html );
fclose($fileopen);
