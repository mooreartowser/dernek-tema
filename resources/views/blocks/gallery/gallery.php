<?php
/**
 * Gallery Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section_title = get_field( 'section_title' ) ?: 'Faaliyetlerimizden Kareler';
$images        = get_field( 'gallery_images' ) ?: [];
$videos        = get_field( 'video_urls' ) ?: [];

ob_start();
?>

<?php if ( ! empty( $section_title ) ) : ?>
    <div class="text-center">
        <h2 class="text-3xl font-bold text-text font-heading">
            <?php echo esc_html( $section_title ); ?>
        </h2>
    </div>
<?php endif; ?>

<!-- Images Section -->
<?php if ( ! empty( $images ) ) : ?>
    <div class="flex flex-col gap-component-sm">
        <h3 class="text-lg font-bold font-heading text-text-muted">Fotoğraflar</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-component-sm">
            <?php foreach ( $images as $img_url ) : ?>
                <a href="<?php echo esc_url( $img_url ); ?>" target="_blank" class="block aspect-video rounded-medium overflow-hidden border border-border bg-surface group relative shadow-sm hover:shadow-md transition-shadow duration-200">
                    <img src="<?php echo esc_url( $img_url ); ?>" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" />
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 flex items-center justify-center transition-all duration-200">
                        <svg class="h-6 w-6 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m4-3H6" />
                        </svg>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Videos Section -->
<?php if ( ! empty( $videos ) ) : ?>
    <div class="flex flex-col gap-component-sm border-t border-border pt-component-lg">
        <h3 class="text-lg font-bold font-heading text-text-muted">Videolar</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-component-md">
            <?php foreach ( $videos as $vid ) : 
                // Try to get YouTube ID to show thumbnail
                $video_id = '';
                if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vid['video_url'], $match ) ) {
                    $video_id = $match[1];
                }
                $thumb_url = $video_id ? 'https://img.youtube.com/vi/' . $video_id . '/0.jpg' : get_template_directory_uri() . '/assets/demo/demo_education.jpg';
                
                ob_start();
                ?>
                <div class="relative w-full aspect-video bg-surface-alt overflow-hidden group">
                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr( $vid['title'] ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" />
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center transition-colors group-hover:bg-black/50">
                        <div class="p-component-sm bg-accent text-white rounded-pill shadow-lg transform group-hover:scale-110 transition-transform duration-200">
                            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-component-sm">
                    <h4 class="text-sm font-bold text-text font-sans group-hover:text-primary transition-colors duration-200">
                        <a href="<?php echo esc_url( $vid['video_url'] ); ?>" target="_blank">
                            <?php echo esc_html( $vid['title'] ); ?>
                        </a>
                    </h4>
                </div>
                <?php
                $card_content = ob_get_clean();
                get_template_part( 'resources/components/card', null, [
                    'class'   => 'flex flex-col rounded-large border border-border bg-surface overflow-hidden group shadow-sm hover:shadow-md transition-shadow duration-200',
                    'content' => $card_content,
                ] );
                ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php
$container_content = ob_get_clean();

ob_start();
get_template_part( 'resources/components/container', null, [
    'class'   => 'flex flex-col gap-component-lg',
    'content' => $container_content,
] );
$section_content = ob_get_clean();

get_template_part( 'resources/components/section', null, [
    'spacing'    => 'md',
    'background' => 'alt',
    'content'    => $section_content,
] );

