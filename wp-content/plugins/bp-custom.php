<?php

function remove_xprofile_links() {
    #remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2 );
    remove_filter( 'xprofile_get_field_data', 'xprofile_filter_format_field_value_by_field_id', 5, 2 ); 
}
add_action( 'bp_init', 'remove_xprofile_links' );

?>
