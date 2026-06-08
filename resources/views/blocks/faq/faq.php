<?php
/**
 * FAQ Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section_title = get_field( 'section_title' ) ?: 'Sıkça Sorulan Sorular';
$faqs          = get_field( 'faqs' ) ?: [];
?>

<?php
/**
 * FAQ Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section_title = get_field( 'section_title' ) ?: 'Sıkça Sorulan Sorular';
$faqs          = get_field( 'faqs' ) ?: [];

ob_start();
?>

<?php if ( ! empty( $section_title ) ) : ?>
    <div class="text-center">
        <h2 class="text-3xl font-bold text-text font-heading">
            <?php echo esc_html( $section_title ); ?>
        </h2>
    </div>
<?php endif; ?>

<?php if ( ! empty( $faqs ) ) : ?>
    <div class="flex flex-col gap-component-sm">
        <?php foreach ( $faqs as $faq ) : ?>
            <details class="group bg-surface rounded-large border border-border overflow-hidden transition-all duration-200 [&_summary::-webkit-details-marker]:hidden shadow-sm">
                <summary class="flex justify-between items-center p-component-md font-bold text-text font-sans cursor-pointer list-none select-none focus:bg-surface-alt">
                    <span>
                        <?php echo esc_html( $faq['question'] ); ?>
                    </span>
                    <span class="transition group-open:-rotate-180 text-primary">
                        <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                    </span>
                </summary>
                <div class="px-component-md pb-component-md text-sm text-text-muted font-sans border-t border-border pt-component-sm">
                    <p class="leading-relaxed">
                        <?php echo esc_html( $faq['answer'] ); ?>
                    </p>
                </div>
            </details>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$container_content = ob_get_clean();

ob_start();
get_template_part( 'resources/components/container', null, [
    'width'   => 'narrow',
    'class'   => 'flex flex-col gap-component-lg',
    'content' => $container_content,
] );
$section_content = ob_get_clean();

get_template_part( 'resources/components/section', null, [
    'spacing'    => 'md',
    'background' => 'default',
    'content'    => $section_content,
] );

