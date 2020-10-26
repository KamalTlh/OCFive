<?php
namespace MyApp\View;

class View{
    private $title;
    private $file;

    public function render($template, $data=[]){
        if( $template === 'administration'){
            $template = 'admin/administration.php';
        }
        $this->file = 'src/view/'.$template.'.php';
        $content = $this->renderFile($this->file, $data);
        $view = $this->renderFile('src/view/FirstTemplate.php', [
            'title' => $this->title,
            'content' => $content
        ]);
        echo $view;
    }

    private function renderFile($file, $data){
        try{
            if(file_exists($file)){
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