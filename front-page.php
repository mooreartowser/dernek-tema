<?php
/**
 * The template for displaying the front page
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

// Fetch Home Slider slides from options page
$slides = get_field( 'home_slides', 'option' );

if ( ! empty( $slides ) && is_array( $slides ) ) : ?>
    <!-- Home Slider System -->
    <div class="relative w-full h-[500px] md:h-[650px] overflow-hidden bg-navy-dark">
        <!-- Slides Container -->
        <div class="slider-wrapper h-full w-full relative">
            <?php foreach ( $slides as $index => $slide ) : 
                $active_class = ( $index === 0 ) ? 'opacity-100 z-10' : 'opacity-0 z-0';
                $desktop_img = $slide['slide_desktop_image']['url'] ?? get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg';
                $mobile_img = ! empty( $slide['slide_mobile_image']['url'] ) ? $slide['slide_mobile_image']['url'] : $desktop_img;
                ?>
                <div class="absolute inset-0 w-full h-full transition-all duration-1000 ease-in-out <?php echo $active_class; ?>" data-slide-index="<?php echo $index; ?>">
                    <!-- Background Image -->
                    <picture class="absolute inset-0 w-full h-full object-cover">
                        <source media="(max-w: 767px)" srcset="<?php echo esc_url( $mobile_img ); ?>">
                        <img src="<?php echo esc_url( $desktop_img ); ?>" alt="<?php echo esc_attr( $slide['slide_title'] ); ?>" class="absolute inset-0 w-full h-full object-cover" />
                    </picture>
                    
                    <!-- Dark Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/40 to-transparent"></div>
                    
                    <!-- Content -->
                    <div class="relative w-full h-full mx-auto px-container-px max-w-container-default z-20 flex items-center">
                        <div class="max-w-2xl flex flex-col gap-4 text-white">
                            <h2 class="text-3.5xl md:text-6xl font-extrabold font-heading tracking-tight leading-tight">
                                <?php echo esc_html( $slide['slide_title'] ); ?>
                            </h2>
                            <?php if ( ! empty( $slide['slide_description'] ) ) : ?>
                                <p class="text-sm md:text-lg text-white/95 font-sans leading-relaxed max-w-xl">
                                    <?php echo esc_html( $slide['slide_description'] ); ?>
                                </p>
                            <?php endif; ?>
                            <?php if ( ! empty( $slide['slide_cta'] ) && ! empty( $slide['slide_cta_url'] ) ) : ?>
                                <div class="mt-2">
                                    <?php
                                    get_template_part( 'resources/components/button', null, [
                                        'variant' => 'primary',
                                        'size' => 'large',
                                        'text' => $slide['slide_cta'],
                                        'url' => $slide['slide_cta_url'],
                                        'class' => 'bg-accent hover:opacity-90 border-0 shadow-md'
                                    ] );
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigation Dots -->
        <?php if ( count( $slides ) > 1 ) : ?>
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-30 flex gap-2.5">
                <?php foreach ( $slides as $index => $slide ) : 
                    $dot_active = ( $index === 0 ) ? 'bg-white scale-125 shadow-sm' : 'bg-white/40 hover:bg-white/70';
                    ?>
                    <button class="w-3 h-3 rounded-full transition-all duration-300 focus:outline-none <?php echo $dot_active; ?>" data-dot-index="<?php echo $index; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ( count( $slides ) > 1 ) : ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('[data-slide-index]');
            const dots = document.querySelectorAll('[data-dot-index]');
            let activeIndex = 0;
            const slideInterval = 6000; // Switch every 6 seconds

            function showSlide(index) {
                slides.forEach((slide, idx) => {
                    if (idx === index) {
                        slide.classList.remove('opacity-0', 'z-0');
                        slide.classList.add('opacity-100', 'z-10');
                    } else {
                        slide.classList.remove('opacity-100', 'z-10');
                        slide.classList.add('opacity-0', 'z-0');
                    }
                });

                dots.forEach((dot, idx) => {
                    if (idx === index) {
                        dot.classList.remove('bg-white/40', 'hover:bg-white/70');
                        dot.classList.add('bg-white', 'scale-125', 'shadow-sm');
                    } else {
                        dot.classList.remove('bg-white', 'scale-125', 'shadow-sm');
                        dot.classList.add('bg-white/40', 'hover:bg-white/70');
                    }
                });

                activeIndex = index;
            }

            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-dot-index'));
                    showSlide(index);
                });
            });

            setInterval(() => {
                let nextIndex = (activeIndex + 1) % slides.length;
                showSlide(nextIndex);
            }, slideInterval);
        });
        </script>
    <?php endif; ?>

<?php else : ?>
    <!-- Fallback Simple Header if no slides exist -->
    <div class="bg-navy-dark text-white py-16">
        <div class="max-w-container-default mx-auto px-container-px">
            <h1 class="text-3xl md:text-5xl font-extrabold font-heading text-white"><?php bloginfo( 'name' ); ?></h1>
            <p class="text-sm md:text-base text-white/80 mt-2"><?php bloginfo( 'description' ); ?></p>
        </div>
    </div>
<?php endif; ?>

<!-- Main content blocks loops -->
<div id="primary" class="content-area flex-1">
    <main id="main" class="site-main">
        <?php
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
        ?>
    </main>
</div>

<?php
get_footer();
