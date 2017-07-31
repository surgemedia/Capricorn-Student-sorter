<div class="wrap">
    <h2>Batch Process</h2>
    <div class="plugin-container">

    <?php   // WP_Query arguments
    $args = array(
        'post_type'              => array( 'photo_shoots' ),
    );

    // The Query
    $query = new WP_Query( $args );
    ?>
   

        <div class="shoot_list" id="ss_shoots_list">
            <ul class="listinline">
                <li>Shoot</li>
                <li>School Name</li>
                <li>Batch date</li>
            </ul>
            <?php
            // The Loop
            if ( $query->have_posts() ) {?>
            
            <?php
                while ( $query->have_posts() ) {
                    $query->the_post(); ?>
                    <ul class="listinline item">
                    <li id="shoot_".<?php echo get_the_id();?> ><?php echo get_the_title();?></li>
                    <li><?php echo get_the_content(); ?></li>
                    <li><?php if(!empty(get_field('batch_date'))){ ?>
                          <?php echo get_field('batch_date'); ?> | <a href="">Download CSV</a>
                        <?php }else{?>
                            <a href="">Process Batch</a> 
                        <?php    } ?> 
                        
                        </li>
                    </ul>
            <?php   } ?>
            
            <?php
            } else {
                // no posts found
            }

            // Restore original Post Data
            wp_reset_postdata();
            ?>  


        </div>
    </div>
</div>
