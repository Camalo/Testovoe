<?php

class View
{
    function __construct()
    {
        // echo "Using a view<br> </br>";
    }
    public function render(string $folder, string $name,array $args)
    {
      //  $name =  $name . '/index.html.twig';
        require "view/header.php";
        $loader = new \Twig\Loader\FilesystemLoader("./view/". $folder . "/");
        $twig = new \Twig\Environment($loader);
        
        $template = $twig->load($name .'.html.twig');
        $args['URL'] = URL;
       
        echo $template->render($args);
        require "view/footer.php";
    }
}
