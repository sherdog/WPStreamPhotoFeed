<?php

 class live_feeds extends WP_Module implements IModule {

    public $name = "Live Feeds";
    public $slug = "";
    public $menuTitle = "Live Feeds";
    public $pageTitle = "Live Feeds";
    public $showInMenu = true;
    public $parent = "";
    public $loader;
    public $sortOrder = 5;
    public $icon = "dashicons-video-alt3";
    public $manangedOptions = "manage_options";
    
    /*
     * 
     *  $fields['youtube_username'] = $_POST['youtube_username'];
        $fields['facebook_username'] = $_POST['facebook_username'];
        $fields['twitch_username'] = $_POST['twitch_username'];
        $fields['name'] = $_POST['name'];
        $fields['state'] = $_POST['state'];
        $fields['zip'] = $_POST['zip'];
        $fields['cashapp_address'] = $_POST['cashapp_address'];
        $fields['venmo_address'] = $_POST['venmo_address'];
        $fields['paypal_address'] = $_POST['paypal_address'];
     */
     
    public function init($loader) {
        $this->loader = $loader;
    }
    
    public function display() {
       
        if ((isset($_GET['live_feed']) && $_GET['live_feed'] != '') ||  (isset($_GET['action']) && $_GET['action'] === 'add')) {
            
            $id = (isset($_GET['live_feed'])) ? $_GET['live_feed'] : '';
            $this->editLiveFeed($id);
            
        } else {
            $this->manageFeeds();            
        }
        
        if (isset($_POST['do_action']) && $_POST['do_action'] != '') {
            $this->updateLiveFeed($_POST, $id);
        }
    }
    
    function updateLiveFeed($post, $id) {
        
        //clean the post data pre save.
        global $wpdb;
        
      
        $streamer_id = -1;
        
        if ($_POST['streamer_id'] !== "") {
            $streamer_id = $_POST['streamer_id'];
        } else {
            
            //QuickSert!
            
            //create new streamer with just the name for now.
            $table = $wpdb->prefix . 'lfp_streamers';
            $streamer = [];
            $streamer['name'] = $_POST['streamer_name'];
            $wpdb->insert($table, $streamer);
            
            $streamer_id = $wpdb->insert_id;
        }
        
        $table = $wpdb->prefix . 'lfp_live_feeds';
        
        $fields = [];
        $fields["url"] = $_POST["url"];
        $fields["title"] = $_POST["title"];
        $fields["hashtags"] = $_POST['hashtags'];
        $fields['city'] = $_POST['city'];
        $fields['state'] = $_POST['state'];
        $fields['zip'] = $_POST['zip'];
        $fields['platform'] = $_POST['platform'];
        $fields['streamer_id'] = $streamer_id;
       
        
        
        if ($_POST['id'] != '') { 
            //we updating.
            $wpdb->update($table, $fields,array('id'=>$id));
        } else {
            $wpdb->insert($table, $fields);
        }
        
    }
    
    function manageFeeds() {
        
        $data = [];
        $data['pageTitle'] = "Live Feeds";
                
        echo $this->loader->get_template()->render('live_feeds/live_feeds_display', $data);
    }
    
    function editLiveFeed($id) {
        
        global $wpdb;
        $data = [];

        $action = ($id != '') ? "Edit" : "Add";
        $data['title'] = ' Live Stream';
        $data['pageTitle'] = $action . " Live Feed";
        
        
        $table = $wpdb->prefix . 'lfp_streamers';
        $data['streamers'] = $wpdb->get_results ("SELECT * FROM " . $table . " ORDER BY name");
        
        $platforms = [];
        $platforms[] = "Youtube";
        $platforms[] = "Twitch";
        $platforms[] = "Facebook";
        $platforms[] = "Periscope";
        $platforms[] = "Other";
        
        $data['platforms'] = $platforms;
        
        if ($id !== '') {
            $table = $wpdb->prefix . 'lfp_live_feeds';
            $data['live_feed'] = $wpdb->get_row("SELECT * FROM " . $table . " WHERE id = " . $id . " LIMIT 1");
        } else {
            $data['live_feed'] = [];
            $data['live_feed']['platform'] = "";
            $data['live_feed']['streamer_id'] = -1;
        }
        
        echo $this->loader->get_template()->render('live_feeds/live_feeds_form', $data);
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