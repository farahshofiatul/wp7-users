<?php
/*
Plugin Name: user_plugin
Version: 1.0
Author: farah shofiatul
*/

class user{
	public function __construct(){
		add_shortcode('wp7_users', array($this, 'show_staff'));
		register_activation_hook( __FILE__, array($this, 'add_roles_on_plugin_activation' ));
		
	}
	function add_roles_on_plugin_activation() {
       add_role( 'Staff', 'Staff', array( 'read' => true, 'edit_posts' => true ) );
   }
   function show_staff(){
   		$big = 999999999;
   		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
   		$args = array( 
   			'role' => 'staff',
   			'number' => 5,
   			'paged' => $paged
   		);

		$user_query = new WP_User_Query( $args );


		if ( ! empty( $user_query->get_results() ) ) {
			echo "<table id='users'>";
			echo "</tr>";
			echo "<th>Name</th>";
			echo "</tr>";
			foreach ( $user_query->get_results() as $user ) {
				echo '<tr>';
				echo '<td>'.$user->display_name.'</td>';
				echo '</tr>';
			}
			echo '</table>';
		} else {
			echo 'No users found.';
		}
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '/page/%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => 5
		) );
    }
}
new user();
?>