<?php
namespace view;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

class View
{
    private FilesystemLoader $loader;
    private Environment $twig;

    function __construct()
    {
        $this->loader = new FilesystemLoader("../view/");
        $this->twig = new Environment($this->loader);
    }
    public function render(string $folder, string $name,array $args)
    {
      
        $template = $this->twig->load($folder."/".$name .'.html.twig');
        $args['URL'] = URL;
       
        echo $template->render($args);
       
    }
}
