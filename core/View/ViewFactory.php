<?php
namespace Core\View;
use Core\App;
class ViewFactory 
{

    /**
     * App object
     *
     * @var Core\App 
     */
    private $app;

    /**
     * constructor 
     *
     * @param Core\App $app
     */
    public function __construct(App $app) {
        $this->app = $app;
    }

    
    public function render(string $viewPath, array $data = [])
    {
        return new View($this->app->file, $viewPath, $data);
    }
}