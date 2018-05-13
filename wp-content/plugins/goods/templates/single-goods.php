<?php
get_header(); ?>
<div id="primary">
    <div id="content" role="main">
    <?php
    $mypost = array( 'post_type' => 'goods', );
    $loop = new WP_Query( $mypost );
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <strong>Наименование: </strong><?php echo esc_html( get_post_meta( get_the_ID(), 'gds_name', true ) ); ?><br />
                <strong>Цена: </strong><?php echo esc_html( get_post_meta( get_the_ID(), 'gds_price', true ) ); ?><br />
                <strong>Статус товара: </strong><?php echo get_post_meta( get_the_ID(), 'gds_state', true ) == 1 ? 'В наличии' : 'Нет на складе'; ?><br />
                <strong>Дата создания: </strong><?php echo get_post_meta( get_the_ID(), 'gds_created_at', true ); ?><br />
                <strong>Атрибуты товара: </strong>
				<ul>
					<?php
					$i=0;
					while( $gds_attr_name_{$i} = get_post_meta($post->ID, "gds_attr_name_{$i}", true)){
						$gds_attr_value_{$i} = get_post_meta($post->ID, "gds_attr_value_{$i}", true);
						print( "<li>" . esc_attr( $gds_attr_name_{$i} ) . ": " . esc_attr( $gds_attr_value_{$i} ) . "</li>" );
						$i++;
					} 
					?>
				</ul>
            </header>
            <div class="entry-content"><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>