<?php
/*
Plugin Name: user_plugin
Version: 1.0
Author: farah shofiatul
*/

class user{
	public function __construct(){
		add_shortcode('wp7_users', array($this, 'show_users'));
		add_shortcode('wp7_users_role', array($this, 'show_users_role'));
		register_activation_hook( __FILE__, array($this, 'add_roles_on_plugin_activation1' ));	
	}

	function add_roles_on_plugin_activation1() {
       add_role( 'Staff', 'Staff', array( 
       	'read' => true, 
       	'edit_posts' => true 
       ) );
       add_role( 'Manager', 'Manager', array( 
       	'read' => true, 
       	'edit_posts' => true, 
       	'add_users' => true, 
       	'list_users' => true, 
       	'remove_users'=> true, 
       	'create_users'=>true, 
       	'delete_users' => true, 
       	'edit_users' => true, 
       	'promote_users' => true,
       	'manage_options' => true,
       	'customize' => true
       ) );
    }

    function show_users(){
   		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
   		$number = 2;
   		$roles = array('staff', 'manager');
   		$args = array( 
   			'number' => $number,
   			'paged' => $paged,
   			'role__in' => [ 'staff', 'manager' ]
   		);

		$user_query = new WP_User_Query( $args );
		$total_users = $user_query->get_total();

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
			'total' => ceil($total_users / $number)
		) );
    }

    function show_users_role($atts){
    	$value = shortcode_atts( array('role' => $atts['role']), $atts );
   		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
   		$number = 2;
   		$args = array( 
   			'role' => $value['role'],
   			'number' => $number,
   			'paged' => $paged
   		);

		$user_query = new WP_User_Query( $args );
		$total_users = $user_query->get_total();

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
			'total' => ceil($total_users / $number)
		) );
    }
}

new user();
?>