<?php
$title = get_field('related_posts_title');
$related_posts = get_field('select_related_posts');
?>

<section class="related-posts">
    <div class="container">
        <div class="header-container d-flex align-items-start flex-column flex-md-row align-items-md-center justify-content-md-between">
            <?php if($title) :  ?>
            <h3 class="mb-sm-0 mb-3"><?php echo $title; ?></h3>
            <?php else :  ?>
            <h3 class="mb-sm-0 mb-3">Related Resources</h3>
            <?php endif;  ?>
            <a href="/resources">View More</a>
        </div>

        <?php if( $related_posts ): ?>
        <div class="post-container">
            <div class="row">
                <?php foreach( $related_posts as $post ): 
                    setup_postdata($post);
                ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="<?php the_permalink(); ?>" class="posts-content d-flex p-3">
                        <h5><?php the_title(); ?></h5>
                        <?php 
                        $author = get_field('select_article_author', get_the_ID());
                        if($author){
                            $authorName = get_field('select_article_author', get_the_ID());
                        }else{
                            $authorName = get_the_author();
                        }
                        ?>
                        <span><?php echo $authorName; ?>, <?php echo get_the_date(); ?></span>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php 
        wp_reset_postdata();
        else : 
            $category = get_the_category();

            $args = array(
                'post_type'     => 'post',
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'orderby'  => 'date',
				'order' => 'DESC',
                'cat'           => $category[0]->cat_ID,
                'post__not_in'  => array( get_the_ID() ),
            );

            $the_query = new WP_Query( $args );
        ?>

        <div class="post-container">
            <div class="row">
                <?php  
                    while ( $the_query->have_posts() ) : 
                    $the_query->the_post();
                ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="<?php the_permalink(); ?>" class="posts-content d-flex p-3">
                        <h5><?php the_title(); ?></h5>
                        <?php 
                        $author = get_field('select_article_author', get_the_ID());
                        if($author){
                            $authorName = get_field('select_article_author', get_the_ID());
                        }else{
                            $authorName = get_the_author();
                        }
                        ?>
                        <span><?php echo $authorName; ?>, <?php echo get_the_date(); ?></span>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <?php
        wp_reset_postdata();
        endif; ?>
    </div>
</section>