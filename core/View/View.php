<?php
namespace Core\View;
use Core\File;


class View implements ViewInterface
{

    /**
     * the html output 
     *
     * @var [string]
     */
    private $output;


    /**
     * construct
     *
     * @param File $file
     * @param string $viewPath
     * @param array $data
     */
    public function __construct(File $file,string $viewPath,array $data) {
        $this->file = $file;
        $this->data = $data;
        $this->preparePath($viewPath);
    }  
    
    /**
     * prepare the path for the view
     */
    public function preparePath(string $viewPath)
    {
        $relativeViewPath = 'app/views/' . $viewPath . '.php';

        if (! $this->file->exists($relativeViewPath)) {
            die('<b>' . $viewPath . ' View</b>' . ' does not exists in Views Folder');
        }

        $this->viewPath =  $this->file->to($relativeViewPath);
    }

     /**
     * Get the view output
     *
     * @return string
     */
    public function getOutput()
    {
        if (is_null($this->output)) {
            ob_start();
            extract($this->data);
            require $this->viewPath;
            $this->output = ob_get_clean();
        }
        return $this->output;
    }

    
    /**
    * {@inheritDoc}
    */
    public function __toString()
    {
        return $this->getOutput();
    }

}