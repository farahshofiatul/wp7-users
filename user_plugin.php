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
   		$number = 2;
   		$args = array( 
   			'role' => 'staff',
   			'number' => $number,
   			'paged' => $paged
   		);

		$user_query = new WP_User_Query( $args );
		$total_users = count_users();
		$total_users = $total_users['total_users'];

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
			'current' => max( 1, get_query_var('paged') ),
			'total' => floor($total_users / $number)
		) );
    }
}
new user();
?>