<?php
namespace MyApp\View;
use MyApp\Config\Session;

class View{
    private $title;
    private $file;
    private $session;
    
    public function __construct(){
        $this->session = new Session($_SESSION);
    }

    public function render($template, $data=[]){
        if( $template === 'administration'){
            $template = 'admin/administration.php';
        }
        $this->file = 'src/view/'.$template.'.php';
        $content = $this->renderFile($this->file, $data);
        $view = $this->renderFile('src/view/FirstTemplate.php', [
            'title' => $this->title,
            'content' => $content,
            'session' => $this->session
        ]);
        echo $view;
    }

    private function renderFile($file, $data){
        // echo 'file name: '.$file;
        try{
            if(file_exists($file)){
                // echo 'exist';
                extract($data);
                ob_start();
                require $file;
                return ob_get_clean();
            }
        }
        catch (Exception $e){
            $notFound = new ErrorController();
            $notFound->errorPage();      
        }
    }
}