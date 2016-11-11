<?php

function remove_xprofile_links() {
    remove_filter( 'xprofile_get_field_data', 'xprofile_filter_format_field_value_by_field_id', 5, 2 ); 
}
add_action( 'bp_init', 'remove_xprofile_links' );
?>
