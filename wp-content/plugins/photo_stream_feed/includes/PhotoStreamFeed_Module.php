<?php 

abstract class PhotoStreamFeed_Module {
    
    public function getPageTitle() { }
    
    public function getMenuTitle() { }
    
    public function getSlug() { }
    
    public function getName() { }
    
    public function getShowInMenu() { }
    
    public function getParent() { }
    
    public function getSortOrder() { }
    
    public function getManagedOptions() { }
    
    public function setParent($parent) { }
    
    public function setSlug($slugName) { }
    
    public function __construct() { }
    
    abstract public function init($loader);
    
    abstract public function display();
    
    abstract  public function deactivate();
    
}