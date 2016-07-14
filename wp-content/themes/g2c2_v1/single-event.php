<?php
  if ( have_posts() ) : while ( have_posts() ) : the_post();

  		$evid = strval(get_the_ID());
  		$evtype = get_field('g2c2-event_type');

  		switch ($evtype) {
  			case 'Networking':
  				$baseurl = 'http://g2c2.greenchemistrynetwork.org/?page_id=24';
  				break;
  			case 'Funding':
  				$baseurl = 'http://g2c2.greenchemistrynetwork.org/?page_id=26';
  				break;
  			default:
  				$baseurl = 'http://g2c2.greenchemistrynetwork.org/?page_id=22';
  		}

  		$redirurl = $baseurl."#".$evid;
  		header('Location: '.$redirurl, 301);

  	endwhile;
  	else: echo 'nope';
  endif;

?>