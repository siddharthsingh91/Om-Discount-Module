<?php 
/**
 * Plugin Name: Om Discount Module
 * Plugin URI: http://sanditsolution.com/
 * Description: Redirecting user to thanks page if they have active membership. 
 * Version: 01.00.01
 * Author: Siddharth Singh
 * Author URI: http://sanditsolution.com/
 * License: A "Slug" license name e.g. GPL2
 */
 
function om_register_script_discount() {

	wp_register_script( 'om_bootstrap_script', plugins_url('/dist/js/bootstrap.min.js', __FILE__),array( 'jquery' ));
	wp_register_script( 'om_sidd_jquery', plugins_url('/dist/js/sidd.js', __FILE__),array( 'jquery' ));

	wp_register_style( 'om_bootstrap_style', plugins_url('/dist/css/bootstrap.min.css', __FILE__));
	wp_register_style( 'om_sidd_style', plugins_url('/dist/css/sidd.css', __FILE__));

	
	wp_localize_script( 'om_sidd_jquery', 'add_to_cart', array( "ajaxurl" => admin_url( "admin-ajax.php" ) ) );

	wp_enqueue_script( 'om_bootstrap_script' );
	wp_enqueue_style( 'om_bootstrap_style' );
	wp_enqueue_script( 'om_sidd_jquery' );
if(is_page(array('set','cart-2','checkout'))){wp_enqueue_style( 'om_sidd_style' );}
}
add_action('wp_enqueue_scripts', "om_register_script_discount");



function om_custom_wc_add_fee() {
global $woocommerce;
$total_no_count = $woocommerce->cart->cart_contents_count;
$om_retail_price_curr = $woocommerce->cart->get_cart_total(); 
$om_retail_price = WC()->cart->cart_contents_total;
$om_symble = get_woocommerce_currency_symbol();
$dis = 0;
switch ($total_no_count) {
	case 2:
	$dis = "7%";	
	$om_discount_price = $om_retail_price * .07;
	break;
	case 3:
		$dis = "9%";	
	$om_discount_price = $om_retail_price * .09;
	break;
	case 4:
		$dis = "11%";
	$om_discount_price = $om_retail_price * .11;
	break;
	case 5:
		$dis = "13%";
	$om_discount_price = $om_retail_price * .13;
	break;	
	case 6:
		$dis = "15%";
	$om_discount_price = $om_retail_price * .15;
	break;		
	default:
	if($total_no_count > 6){$om_discount_price = $om_retail_price * .15;}else{
	   $om_discount_price = 0;}
}
 WC()->cart->add_fee( 'Discount', -$om_discount_price ); 
$om_total_price_aft_discount =  $om_retail_price-$om_discount_price;
ob_start();
?>
<div class="new-bar-discount-two">
  <ul>
   <li><b>RETAIL PRICE : </b><span> <?php echo $om_retail_price_curr; ?></span></li>
   <li><b>YOUR PRICE : </b><span> <?php echo $om_symble.$om_total_price_aft_discount; ?></span></li>
   <!-- <li><b>Congrats! Your are saving : </b><span> <?php echo $om_symble.$om_discount_price; ?></span></li> -->
  </ul>
</div>
<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove">&nbsp;</th>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name">Product</th>
				<th class="product-price">Price</th>
				<th class="product-quantity">Discount</th>
				<th class="product-subtotal">Subtotal</th>
			</tr>
		</thead>
        <tr class="woocommerce-cart-form__cart-item cart_item">
        <th class="product-remove">&nbsp;</th>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name"><?php echo $total_no_count; ?> Product set</th>
				<th class="product-price"><?php echo $om_retail_price_curr; ?></th>
				<th class="product-quantity"><?php echo $dis; ?></th>
				<th class="product-subtotal"><?php echo $om_symble.$om_total_price_aft_discount; ?></th>
        </tr>
</table>
<?php
$om_result_value=ob_get_clean();

if(is_page('cart-2') || is_page('checkout')){
	
echo $om_result_value; 
}}
add_action( 'woocommerce_cart_calculate_fees','om_custom_wc_add_fee' );




/*********************************************
******Ajax auto update the price and amount***
*********************WooComerce***************
**********************************************/
add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
function iconic_cart_count_fragments( $fragments ) {
global $woocommerce;
$total_no_count = $woocommerce->cart->cart_contents_count;
$om_retail_price_curr = $woocommerce->cart->get_cart_total(); 
$om_retail_price = WC()->cart->cart_contents_total;
$om_symble = get_woocommerce_currency_symbol();
switch ($total_no_count) {
	case 2:
	$om_discount_price = $om_retail_price * .07;
	break;
	case 3:
	$om_discount_price = $om_retail_price * .09;
	break;
	case 4:
	$om_discount_price = $om_retail_price * .11;
	break;
	case 5:
	$om_discount_price = $om_retail_price * .13;
	break;	
	case 6:
	$om_discount_price = $om_retail_price * .15;
	break;		
	default:
	if($total_no_count > 6){$om_discount_price = $om_retail_price * .15;}else{
	   $om_discount_price = 0;}
}
$om_total_price_aft_discount =  $om_retail_price-$om_discount_price;

	$fragments['div.new-bar-discount'] = '<div class="new-bar-discount">
	<ul>
	 <li><b>RETAIL PRICE : </b><span>'. $om_retail_price_curr.'</span></li>
	 <li><b>YOUR PRICE : </b><span>'.$om_symble.$om_total_price_aft_discount.'</span></li>
	 <li><b>Congrats! Your are saving : </b><span>'.$om_symble.$om_discount_price.'</span></li>
	</ul>
  </div>';
    return $fragments;
}


function om_shortcode_home(){
	
	global $woocommerce;
$total_no_count = $woocommerce->cart->cart_contents_count;
$om_retail_price_curr = $woocommerce->cart->get_cart_total(); 
$om_retail_price = WC()->cart->cart_contents_total;
$om_symble = get_woocommerce_currency_symbol();
switch ($total_no_count) {
	case 2:
	$om_discount_price = $om_retail_price * .07;
	break;
	case 3:
	$om_discount_price = $om_retail_price * .09;
	break;
	case 4:
	$om_discount_price = $om_retail_price * .11;
	break;
	case 5:
	$om_discount_price = $om_retail_price * .13;
	break;	
	case 6:
	$om_discount_price = $om_retail_price * .15;
	break;		
	default:
	if($total_no_count > 6){$om_discount_price = $om_retail_price * .15;}else{
	   $om_discount_price = 0;}
}
$om_total_price_aft_discount =  $om_retail_price-$om_discount_price;

  
	$om_result = '<div class="new-bar-discount">
	<ul>
	 <li><b>RETAIL PRICE : </b><span>'. $om_retail_price_curr.'</span></li>
	 <li><b>YOUR PRICE : </b><span>'.$om_symble.$om_total_price_aft_discount.'</span></li>
	 <li><b>Congrats! Your are saving : </b><span>'.$om_symble.$om_discount_price.'</span></li>
	</ul>
  </div><br/><br/>';

  $om_result .= '<div class="et_pb_button_module_wrapper et_pb_button_0_wrapper et_pb_button_alignment_center et_pb_module ">
<a class="et_pb_button et_pb_custom_button_icon et_pb_button_0 et_hover_enabled et_pb_bg_layout_light" href="'.home_url().'/cart-2/" data-icon="9">ADD SET TO CART</a>
</div><br/><br/>';

  $om_result .= do_shortcode('[products limit="-1" columns="3" class="quick-sale"]');
  
    return $om_result;
	
	}
add_shortcode('om_shortcode_products', 'om_shortcode_home');


/**
 * @snippet       Remove Add Cart, Add View Product @ WooCommerce Loop
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.6.2
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
// First, remove Add to Cart Button
  
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
  
// Second, add View Product Button
 
add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_view_product_button', 10 );
function bbloomer_view_product_button() {
global $product;
$link = $product->get_permalink();
$proQuant = getProQuant($product->get_id());
if($proQuant==""){ $proQuant=0; }
$result_show = '<div class="button addtocartbutton om_add_to_bag"><input class="pro_quant_input" min=0 type="number" name="product_quantity" value="'.$proQuant.'" id="'.$product->get_id().'" price="'.$product->get_price().'"/><span>ADD</span></div>';

if(is_page('set')){ echo $result_show;}
} 




add_action( 'wp_ajax_add_foobar', 'prefix_ajax_add_foobar' );
add_action( 'wp_ajax_nopriv_add_foobar', 'prefix_ajax_add_foobar' );

function prefix_ajax_add_foobar() {
	global $woocommerce;

$om_pro_pri = $_POST['om_pro_pri'];
$om_pro_id = $_POST['om_pro_id'];
$om_pro_qunt = $_POST['om_pro_qunt'];



// Removinf the product form cart start
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	if ( $cart_item['product_id'] == $om_pro_id ) {
		 WC()->cart->remove_cart_item( $cart_item_key );
	}
}
// Removinf the product form cart end

if($om_pro_qunt > 0){
WC()->cart->add_to_cart( $om_pro_id , $om_pro_qunt );
}



$total_no_count = $woocommerce->cart->cart_contents_count;
$om_retail_price_curr = $woocommerce->cart->get_cart_total(); 
$om_retail_price = WC()->cart->cart_contents_total;
$om_symble = get_woocommerce_currency_symbol();
switch ($total_no_count) {
	case 2:
	$om_discount_price = $om_retail_price * .07;
	break;
	case 3:
	$om_discount_price = $om_retail_price * .09;
	break;
	case 4:
	$om_discount_price = $om_retail_price * .11;
	break;
	case 5:
	$om_discount_price = $om_retail_price * .13;
	break;	
	case 6:
	$om_discount_price = $om_retail_price * .15;
	break;		
	default:
	if($total_no_count > 6){$om_discount_price = $om_retail_price * .15;}else{
	   $om_discount_price = 0;}
}
$om_total_price_aft_discount =  $om_retail_price-$om_discount_price;
   
	$om_result = '<ul>
	 <li><b>RETAIL PRICE : </b><span>'. $om_retail_price_curr.'</span></li>
	 <li><b>YOUR PRICE : </b><span>'.$om_symble.$om_total_price_aft_discount.'</span></li>
	 <li><b>Congrats! Your are saving : </b><span>'.$om_symble.$om_discount_price.'</span></li>
	</ul>';
echo $om_result;

die();
}

function getProQuant( $pro_id ){
	foreach ( WC()->cart->get_cart() as $cart_item ) { 
		if($cart_item['product_id'] == $pro_id ){
			$getProQuant =  $cart_item['quantity'];
			break; // stop the loop if product is found
		}
	}
return $getProQuant;
}



/**
 * When an item is added to the cart, check total cart quantity
 */
function so_21363268_limit_cart_quantity( $valid, $product_id, $quantity ) {

    $max_allowed = 6;
    $current_cart_count = WC()->cart->get_cart_contents_count();

    if( ( $current_cart_count > $max_allowed || $current_cart_count + $quantity > $max_allowed ) && $valid ){
        wc_add_notice( sprint( __( 'Whoa hold up. You can only have %d items in your cart', 'om-discount-module' ), $max ), 'error' );
        $valid = false;
    }

    return $valid;

}
add_filter( 'woocommerce_add_to_cart_validation', 'so_21363268_limit_cart_quantity', 10, 3 ); ?>