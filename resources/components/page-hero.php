<?php
/**
 * Global Page Hero Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = $args['title'] ?? get_the_title();
$description = $args['description'] ?? '';
$bg_image    = $args['bg_image'] ?? '';

// Fallback image checks
if ( empty( $bg_image ) ) {
    if ( is_404() ) {
        $bg_img_arr = get_field( 'default_404_hero', 'option' );
        if ( is_array( $bg_img_arr ) ) $bg_image = $bg_img_arr['url'];
    } elseif ( is_singular( 'project' ) || is_post_type_archive( 'project' ) ) {
        if ( is_singular( 'project' ) && has_post_thumbnail() ) {
            $bg_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        }
        if ( empty( $bg_image ) ) {
            $bg_img_arr = get_field( 'default_project_hero', 'option' );
            if ( is_array( $bg_img_arr ) ) {
                $bg_image = $bg_img_arr['url'];
            } else {
                $bg_img_arr = get_field( 'default_page_hero', 'option' );
                if ( is_array( $bg_img_arr ) ) $bg_image = $bg_img_arr['url'];
            }
        }
    } elseif ( is_singular( 'activity' ) || is_post_type_archive( 'activity' ) ) {
        if ( is_singular( 'activity' ) && has_post_thumbnail() ) {
            $bg_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        }
        if ( empty( $bg_image ) ) {
            $bg_img_arr = get_field( 'default_activity_hero', 'option' );
            if ( is_array( $bg_img_arr ) ) {
                $bg_image = $bg_img_arr['url'];
            } else {
                $bg_img_arr = get_field( 'default_page_hero', 'option' );
                if ( is_array( $bg_img_arr ) ) $bg_image = $bg_img_arr['url'];
            }
        }
    } else {
        $custom_hero = get_field( 'custom_hero_image', get_the_ID() );
        if ( is_array( $custom_hero ) && ! empty( $custom_hero['url'] ) ) {
            $bg_image = $custom_hero['url'];
        } elseif ( is_string( $custom_hero ) && ! empty( $custom_hero ) ) {
            $bg_image = $custom_hero;
        }

        if ( empty( $bg_image ) && has_post_thumbnail() ) {
            $bg_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        }

        if ( empty( $bg_image ) ) {
            $bg_img_arr = get_field( 'default_page_hero', 'option' );
            if ( is_array( $bg_img_arr ) && ! empty( $bg_img_arr['url'] ) ) {
                $bg_image = $bg_img_arr['url'];
            }
        }
    }
}

// Global fallback if everything is empty
if ( empty( $bg_image ) ) {
    $bg_image = get_template_directory_uri() . '/assets/demo/demo_relief.jpg';
}

// Fallback description checks
if ( empty( $description ) ) {
    $custom_desc = get_field( 'custom_hero_description', get_the_ID() );
    if ( ! empty( $custom_desc ) ) {
        $description = $custom_desc;
    } elseif ( is_archive() ) {
        $description = get_the_archive_description();
    } elseif ( is_single() || is_page() ) {
        $description = get_the_excerpt();
    }
}
?>

<section class="relative w-full bg-navy-dark py-14 md:py-20 overflow-hidden text-white">
    <!-- Background image container with premium styling -->
    <div class="absolute inset-0 w-full h-full">
        <img src="<?php echo esc_url( $bg_image ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="w-full h-full object-cover opacity-15 filter grayscale contrast-125" />
        <div class="absolute inset-0 bg-gradient-to-r from-navy-dark via-navy-dark/95 to-transparent"></div>
    </div>

    <!-- Content container -->
    <div class="relative w-full mx-auto px-container-px max-w-container-default z-10 flex flex-col gap-4">
        <!-- Render breadcrumb -->
        <?php get_template_part( 'resources/components/breadcrumb' ); ?>

        <!-- Heading & Details -->
        <div class="max-w-3xl flex flex-col gap-2.5 mt-2">
            <h1 class="text-3xl md:text-5xl font-extrabold font-heading text-white tracking-tight leading-tight">
                <?php echo esc_html( $title ); ?>
            </h1>
            <?php if ( ! empty( $description ) ) : ?>
                <p class="text-sm md:text-base text-white/80 font-sans leading-relaxed max-w-2xl">
                    <?php echo esc_html( $description ); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>
