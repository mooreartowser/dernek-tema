<?php
/**
 * CRM Donation Card Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = $args['title'] ?? '';
$desc        = $args['description'] ?? '';
$image_url   = ! empty( $args['image_url'] ) ? $args['image_url'] : get_template_directory_uri() . '/assets/placeholder.jpg';
$badge_text  = $args['badge_text'] ?? '';
$price       = isset( $args['price'] ) ? (float) $args['price'] : null;
$url         = $args['donation_url'] ?? '#';
$collected   = $args['collected_amount'] ?? 0;
$target      = $args['target_amount'] ?? 0;
$percentage  = $args['percentage'] ?? 0;

// Form and variant parameters
$product_code  = $args['product_code'] ?? '';
$variants      = $args['variants'] ?? [];
$selected_idx  = $args['selected_variant_index'] ?? 0;

$has_multiple_variants = count( $variants ) > 1;
$selected_variant      = $has_multiple_variants ? $variants[$selected_idx] : null;
$is_variable           = $args['is_variable'] ?? ( $has_multiple_variants ? ($selected_variant['amount'] <= 0) : ($price <= 0 || $price === null) );
$active_code           = $has_multiple_variants ? $selected_variant['product_code'] : $product_code;
$active_price          = $has_multiple_variants ? $selected_variant['amount'] : $price;
?>

<?php
$form_id = 'donation_form_' . uniqid();
?>
<form id="<?php echo esc_attr( $form_id ); ?>" 
      class="donation-form group flex flex-col h-full relative" 
      action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" 
      method="post" 
      autocomplete="off">
      
    <input type="hidden" name="action" value="peta_add_to_cart">
    <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce( 'peta_add_to_cart' ); ?>">
    <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/odeme/' ) ); ?>">
    
    <?php if ( ! $has_multiple_variants ) : ?>
        <input type="hidden" name="product_code" value="<?php echo esc_attr( $active_code ); ?>">
    <?php endif; ?>

    <?php
    ob_start();
    ?>

    <!-- 1. Top Left Badge -->
    <?php if ( ! empty( $badge_text ) ) : ?>
        <div class="absolute top-4 left-4 z-10">
            <?php get_template_part( 'resources/components/crm/donation-badge', null, [
                'text'    => $badge_text,
                'variant' => 'accent'
            ] ); ?>
        </div>
    <?php endif; ?>

    <!-- 2. Centered Image / Illustration -->
    <div class="relative w-full h-56 overflow-hidden bg-surface-alt/10">
        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
    </div>

    <!-- 3. Card Body (Centered text & inputs) -->
    <div class="p-5 flex-1 flex flex-col justify-between gap-4">
        
        <!-- Title & Description -->
        <div class="text-center flex flex-col gap-2">
            <h3 class="font-heading font-bold text-base md:text-lg text-secondary group-hover:text-primary transition-colors leading-snug">
                <?php echo esc_html( $title ); ?>
            </h3>
            <?php if ( ! empty( $desc ) ) : ?>
                <p class="font-sans text-xs text-text-muted leading-relaxed line-clamp-2">
                    <?php echo esc_html( $desc ); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Inputs and Controls Container -->
        <div class="flex flex-col gap-4 items-center">
            
            <!-- Progress Tracker (if target amount is provided) -->
            <?php if ( $target > 0 ) : ?>
                <div class="w-full bg-surface-alt/40 p-3 rounded-medium border border-border/40">
                    <?php get_template_part( 'resources/components/crm/donation-progress', null, [
                        'collected_amount' => $collected,
                        'target_amount'    => $target,
                        'percentage'       => $percentage,
                    ] ); ?>
                </div>
            <?php endif; ?>

            <!-- 4. Dropdown Selector (Variants) using select component -->
            <?php if ( $has_multiple_variants ) : ?>
                <div class="w-full">
                    <?php
                    $select_options = [];
                    foreach ( $variants as $v ) {
                        $select_options[$v['product_code']] = [
                            'label'      => $v['label'],
                            'attributes' => [
                                'data-price' => $v['amount']
                            ]
                        ];
                    }
                    get_template_part( 'resources/components/select', null, [
                        'name'        => 'product_code',
                        'options'     => $select_options,
                        'input_class' => 'product-variant-select block w-full rounded-medium border-border px-3.5 py-2 text-xs font-semibold text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/30 font-sans text-center',
                    ] );
                    ?>
                </div>
            <?php endif; ?>

            <!-- 5. Amount Input / Price Pill Container (Kept raw as an inline amount field design exception) -->
            <input type="hidden" name="unit_amount" class="unit-amount-hidden" value="<?php echo esc_attr( $is_variable ? '250' : $active_price ); ?>">
            <div class="w-full relative rounded-medium border border-border/65 bg-surface-alt/10 py-2 px-4 flex items-center justify-center h-10 font-sans">
                <input type="<?php echo $is_variable ? 'number' : 'text'; ?>" 
                       name="amount" 
                       value="<?php echo $is_variable ? '250' : number_format( $active_price, 0, ',', '.' ); ?>" 
                       min="20"
                       <?php echo $is_variable ? '' : 'readonly'; ?>
                       class="price-input text-center font-black text-sm text-secondary bg-transparent border-0 p-0 focus:outline-none focus:ring-0 w-24 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" />
                <span class="price-suffix ml-1 font-bold text-xs text-text-muted">₺</span>
            </div>

            <!-- 6. Quantity Selector (Always visible on all cards) -->
            <div class="flex items-center justify-center">
                <?php get_template_part( 'resources/components/quantity-selector', null, [
                    'name' => 'quantity',
                ] ); ?>
            </div>
        </div>

    </div>

    <!-- 7. Sepete Ekle Button (Styled using btn classes) -->
    <div class="px-5 pb-5 pt-0">
        <button type="submit" class="btn btn-primary w-full gap-2">
            <i class="ri-shopping-basket-2-line"></i>
            <?php esc_html_e( 'Sepete Ekle', 'dernek-tema' ); ?>
        </button>
    </div>

    <?php
    $card_content = ob_get_clean();
    get_template_part( 'resources/components/card', null, [
        'class'   => 'flex flex-col h-full bg-white border border-border rounded-large shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden relative',
        'content' => $card_content
    ] );
    ?>
</form>

