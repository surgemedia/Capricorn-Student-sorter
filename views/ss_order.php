    <div class="wrap">
        <h2>Get Orders</h2>
    </div>

		<?php  
		function get_order_details($order_id){

    // 1) Get the Order object
    $order = wc_get_order( $order_id );

    // OUTPUT
    echo '<h3>RAW OUTPUT OF THE ORDER OBJECT: </h3>';
    print_r($order);
    echo '<br><br>';
    echo '<h3>THE ORDER OBJECT (Using the object syntax notation):</h3>';
    echo '$order->order_type: ' . $order->order_type . '<br>';
    echo '$order->id: ' . $order->id . '<br>';
    echo '<h4>THE POST OBJECT:</h4>';
    echo '$order->post->ID: ' . $order->post->ID . '<br>';
    echo '$order->post->post_author: ' . $order->post->post_author . '<br>';
    echo '$order->post->post_date: ' . $order->post->post_date . '<br>';
    echo '$order->post->post_date_gmt: ' . $order->post->post_date_gmt . '<br>';
    echo '$order->post->post_content: ' . $order->post->post_content . '<br>';
    echo '$order->post->post_title: ' . $order->post->post_title . '<br>';
    echo '$order->post->post_excerpt: ' . $order->post->post_excerpt . '<br>';
    echo '$order->post->post_status: ' . $order->post->post_status . '<br>';
    echo '$order->post->comment_status: ' . $order->post->comment_status . '<br>';
    echo '$order->post->ping_status: ' . $order->post->ping_status . '<br>';
    echo '$order->post->post_password: ' . $order->post->post_password . '<br>';
    echo '$order->post->post_name: ' . $order->post->post_name . '<br>';
    echo '$order->post->to_ping: ' . $order->post->to_ping . '<br>';
    echo '$order->post->pinged: ' . $order->post->pinged . '<br>';
    echo '$order->post->post_modified: ' . $order->post->post_modified . '<br>';
    echo '$order->post->post_modified_gtm: ' . $order->post->post_modified_gtm . '<br>';
    echo '$order->post->post_content_filtered: ' . $order->post->post_content_filtered . '<br>';
    echo '$order->post->post_parent: ' . $order->post->post_parent . '<br>';
    echo '$order->post->guid: ' . $order->post->guid . '<br>';
    echo '$order->post->menu_order: ' . $order->post->menu_order . '<br>';
    echo '$order->post->post_type: ' . $order->post->post_type . '<br>';
    echo '$order->post->post_mime_type: ' . $order->post->post_mime_type . '<br>';
    echo '$order->post->comment_count: ' . $order->post->comment_count . '<br>';
    echo '$order->post->filter: ' . $order->post->filter . '<br>';
    echo '<h4>THE ORDER OBJECT (again):</h4>';
    echo '$order->order_date: ' . $order->order_date . '<br>';
    echo '$order->modified_date: ' . $order->modified_date . '<br>';
    echo '$order->customer_message: ' . $order->customer_message . '<br>';
    echo '$order->customer_note: ' . $order->customer_note . '<br>';
    echo '$order->post_status: ' . $order->post_status . '<br>';
    echo '$order->prices_include_tax: ' . $order->prices_include_tax . '<br>';
    echo '$order->tax_display_cart: ' . $order->tax_display_cart . '<br>';
    echo '$order->display_totals_ex_tax: ' . $order->display_totals_ex_tax . '<br>';
    echo '$order->display_cart_ex_tax: ' . $order->display_cart_ex_tax . '<br>';
    echo '$order->formatted_billing_address->protected: ' . $order->formatted_billing_address->protected . '<br>';
    echo '$order->formatted_shipping_address->protected: ' . $order->formatted_shipping_address->protected . '<br><br>';
    echo '- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br><br>';

    // 2) Get the Order meta data
    $order_meta = get_post_meta($order_id);

    echo '<h3>RAW OUTPUT OF THE ORDER META DATA (ARRAY): </h3>';
    print_r($order_meta);
    echo '<br><br>';
    echo '<h3>THE ORDER META DATA (Using the array syntax notation):</h3>';
    echo '$order_meta[_order_key][0]: ' . $order_meta[_order_key][0] . '<br>';
    echo '$order_meta[_order_currency][0]: ' . $order_meta[_order_currency][0] . '<br>';
    echo '$order_meta[_prices_include_tax][0]: ' . $order_meta[_prices_include_tax][0] . '<br>';
    echo '$order_meta[_customer_user][0]: ' . $order_meta[_customer_user][0] . '<br>';
    echo '$order_meta[_billing_first_name][0]: ' . $order_meta[_billing_first_name][0] . '<br><br>';
    echo 'And so on ……… <br><br>';
    echo '- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br><br>';

    // 3) Get the order items
    $items = $order->get_items();

    echo '<h3>RAW OUTPUT OF THE ORDER ITEMS DATA (ARRAY): </h3>';

    foreach ( $items as $item_id => $item_data ) {

        echo '<h4>RAW OUTPUT OF THE ORDER ITEM NUMBER: '. $item_id .'): </h4>';
        print_r($item);
        echo '<br><br>';
        echo 'Item ID: ' . $item_id. '<br>';
        echo '$item["product_id"] <i>(product ID)</i>: ' . $item['product_id'] . '<br>';
        echo '$item["name"] <i>(product Name)</i>: ' . $item['name'] . '<br>';

        // Using get_item_meta() method
        echo 'Item quantity <i>(product quantity)</i>: ' . $order->get_item_meta($item_id, '_qty', true) . '<br><br>';
        echo 'Item line total <i>(product quantity)</i>: ' . $order->get_item_meta($item_id, '_line_total', true) . '<br><br>';
        echo 'And so on ……… <br><br>';
        echo '- - - - - - - - - - - - - <br><br>';
    }
    echo '- - - - - - E N D - - - - - <br><br>';
}

$user = get_user_by('login','109rkwb16');
$user_id = $user->id;
$filters = array(
    'post_status' => 'any',
    'meta_key'    => '_customer_user',
    'meta_value'  => $user_id,
    'post_type'   => wc_get_order_types(),
    // 'posts_per_page' => 200,
    // 'paged' => 1,
    // 'orderby' =>'modified',
    'order' => 'ASC'
);

$loop = new WP_Query( $filters );

while ( $loop->have_posts() ) {
    $loop->the_post();
    $order = new WC_Order($loop->post->ID); 
	   update_post_meta( $post_id = $loop->post->ID, $key = 'family_image', $value = 'Steve' );
       update_post_meta( $post_id = $loop->post->ID, $key = 'simple_image', $value = wp_upload_dir()['basedir'] . '/student_sorter_uploads'.'/'.'working_photos/002_image.png' );
    ?>
       <pre><?php print_r( get_post_meta($loop->post->ID)) ?></pre>
    <?php	
   

    foreach ($order->get_items() as $key => $lineItem) { 

    
  }
    // get_order_details($loop->post->ID);
}

// $customer_orders = get_posts( array(
//     'numberposts' => -1,
//     'meta_key'    => '_customer_user',
//     'meta_value'  => $user_id,
//     'post_type'   => wc_get_order_types(),
//     'post_status' => array_keys( wc_get_order_statuses() ),
// ) );

              ?>
    <!-- <pre><?php print_r($customer_orders) ?></pre> -->

   <?php //update_post_meta( $post_id = 76, $key = 'my_key', $value = 'Steve' ); ?>