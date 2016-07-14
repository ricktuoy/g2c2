<h1>Upcoming Funding Deadlines</h1>
      
<?php
$args = array( 
  'post_type' => 'event',
  'orderby' => 'meta_value',
  'order' => 'ASC',
  'meta_key' => 'g2c2-event_date',
  'meta_query' => array(
      array(
          'key' => 'g2c2-event_type',
          'value' => 'Funding',
          'compare' => 'IN',
       ),
      array(
          'key' => 'g2c2-event_date',
          'value' => date('Ymd'),
          'compare' =>  '>',
          'type' => 'DATE'
       )   
   )
 );
$loop = new WP_Query( $args );

if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
?>
  
    <a href="<?php the_permalink(); ?>">
    <article class="agenda-event">
      <table>
       <tr>
         <td><span class="agenda-event-date">
          <?php 
            $ed = DateTime::createFromFormat('Ymd', get_field('g2c2-event_date'));
            echo $ed->format('j F Y');
          ?>
        </span></td>
         <td><h3><?php the_field('g2c2-event_widgetText'); ?></h3></td>
       </tr>
      </table>
    </article>
  </a>


<?php endwhile; else : ?>
	<em style="color: #808080;">No deadlines</em>
<?php endif; ?>