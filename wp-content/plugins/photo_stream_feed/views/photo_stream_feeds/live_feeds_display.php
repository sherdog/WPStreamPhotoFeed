<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class PhotoFeedsDisplay extends WP_List_Table {
    
    public function __construct() {
    
        parent::__construct([   
            'singular' => 'Live Feed',
            'plural' => 'Live Feeds',
            'ajax' => true
        ]);
    }
    
    public function no_items() {
        echo 'No photo feeds returned';
    }
    
    public function column_default($item, $column_name) {
        return $item[$column_name];
    }
    
    function extra_tablenav( $which ) {
        if ( $which == "top" ){
            echo sprintf('<h2><a href="?page=%s&action=%s" class="add-new-h2">Add new</a></h2>',$_REQUEST['page'],'add');
        }
    }
    
    function column_title( $item ) {
        
        // create a nonce
        $delete_nonce = wp_create_nonce( 'sp_deleteLiveFeed' );
        
        $actions = [
            'edit' => sprintf('<a href="?page=%s&action=%s&live_feed=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
            'delete' => sprintf( '<a href="?page=%s&action=%s&live_feed=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
        ];
        
        return $item['title'] . $this->row_actions( $actions );
    }
    
    function get_columns() {
        $columns = [
            'cb'      => '<input type="checkbox" />',
            'id'        => __('ID'),
            'title'    => __( 'Title'),
            'hashtags' => __( 'Hashtags' ),
            'url'    => __( 'Url' ),
            'title' => __('Title')
        ];
        return $columns;
    }
    
    public function get_sortable_columns() {
        $sortable_columns = array(
            'title' => array( 'title', true ),
            'hashtags' => array( 'hashtags', false ),
            'id' => array('id', true)
        );
        
        return $sortable_columns;
    }
    
    public function get_bulk_actions() {
        $actions = [
            'bulk-delete' => 'Delete'
        ];
        
        return $actions;
    }
    
    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {
        
        
        $this->_column_headers = array(
            $this->get_columns(),       // columns
            array(),           // hidden
            $this->get_sortable_columns(),  // sortable
        );
       
        /** Process bulk action */
        $this->process_bulk_action();
        
        $per_page     = $this->get_items_per_page( 'customers_per_page', 5 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();
        
        $this->set_pagination_args( [
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ] );
        
        $this->items = self::getLiveFeeds( $per_page, $current_page );
    }
    
    public static function getLiveFeeds( $perPage = 10, $pageNumber = 1) {
        global $wpdb;
        
        $sql =  "SELECT title, hashtags, url, id, title FROM {$wpdb->prefix}lfp_live_feeds";
        $sql .= " LIMIT $perPage";
        $sql .= " OFFSET " . ($pageNumber - 1) * $perPage;
        
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        
        
        return $result;
    }
    
    public static function deleteLiveFeed( $id ) {
        global $wpdb;
        
        $wpdb->delete(
            "{$wpdb->prefix}lfp_live_feeds",
            [ 'id' => $id ],
            [ '%d' ]
        );
    }
    
    public static function record_count() {
        global $wpdb;
        
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}lfp_live_feeds";
        
        return $wpdb->get_var( $sql );
    }
    
    public function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if ( 'delete' === $this->current_action() ) {
            
            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );
            
            if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::delete_customer( absint( $_GET['customer'] ) );
                
                wp_redirect( esc_url( add_query_arg() ) );
                exit;
            }
            
        }
        
        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
            || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
            ) {
                
                $delete_ids = esc_sql( $_POST['bulk-delete'] );
                
                // loop over the array of record IDs and delete them
                foreach ( $delete_ids as $id ) {
                    self::deleteLiveFeed( $id );
                    
                }
                
                wp_redirect( esc_url( add_query_arg() ) );
                exit;
            }
    }
}

$liveFeeds = new PhotoFeedsDisplay();
?>

<div class="wrap">
	<h2>Live Streams</h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<form method="post">
						<?php
						$liveFeeds->prepare_items();
						echo $liveFeeds->display(); 
						?>
					</form>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>









