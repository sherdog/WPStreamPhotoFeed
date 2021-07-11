<?php

 class live_feed_options extends WP_Module implements IModule {

    public $name = "Live Stream Options";
    public $slug = "";
    public $menuTitle = "Stream Options";
    public $pageTitle = "Options";
    public $showInMenu = true;
    public $parent = "";
    public $loader;
    public $sortOrder = 2;
    public $icon = "";
    public $manangedOptions = "manage_options";
     
    public function init($loader) {
        $this->loader = $loader;
    }
    
    public function display()
    {
        echo "<h1>" . $this->pageTitle . "</h1>";
    }

    public function deactivate()
    {}
    
    
    
    
    /**
     * GETTERS SETTERS
     */
    
    public function getPageTitle() {
        return $this->pageTitle;
    }
    
    public function getMenuTitle() {
        return $this->menuTitle;
    }
    
    public function getSlug() {
        return $this->slug;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getShowInMenu() {
        return $this->showInMenu;
    }
    
    public function getParent() {
        return $this->parent;
    }
    
    public function getSortOrder() {
        return $this->sortOrder;
    }
    
    public function getManagedOptions() {
        return $this->manangedOptions;
    }
    
    public function getIcon() {
        return $this->icon;
    }
    
    public function setParent($parent) {
        $this->parent = $parent;
    }
    
    public function setSlug($slugName) {
        $this->slug = $slugName;
    }
    
}