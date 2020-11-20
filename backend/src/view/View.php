<?php
namespace MyApp\view;

class View{
    private $file;

    public function render($template, $data=[]){
        $this->file = 'src/view/'.$template.'.php';
        $content = $this->renderFile($this->file, $data);
        echo $content;
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