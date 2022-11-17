<?php require 'vendor/autolad.php'; ?>
<?php use League\CommonMark\CommonMarkConverter; ?>
<?php $converter = new CommonMarkConverter([
    'html_input' => 'strip',
    'allow_unsafe_links' => false,
]); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello !</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lora">
    <style>
        html{ background: #265B91 }
        body{ margin: 0; padding: 30px; font-family: 'Lora', serif; }
        *{ font-size: 25px; color: #DCE3ED; font-weight: normal }
        h1{ display: inline-block; }
        div{ font-size: 80px}
    </style>
</head>
<body>
    Bonjour, je suis <h1>Dorian Mongel</h1>, vous pourrez me retrouver sur la toile sur <a href="https://twitter.com/dorianmongel">twitter</a>, <a href="https://www.instagram.com/dorianmongel/">instagram</a>, <a href="https://unsplash.com/@_dorian_">unsplash</a> ou <a href="https://www.linkedin.com/in/dorianmongel/">linkedin</a>.<br />
    On peut également se voir autour d'un café à l'<strong><a href="https://www.hiboost.fr">agence hiboost</a></strong>.

    <?php $scandir = scandir("./posts"); ?>
    <?php foreach($scandir as $fichier){ ?>
        <?php $post = file_get_contents('posts/$fichier'); ?>
        <article>
            <?php echo  $converter->convert($post); ?>
        </article>
    <?php } ?>

</body>
</html>