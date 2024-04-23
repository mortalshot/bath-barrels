<?php 
get_header(); 

echo '<main class="page">';
	echo '<section class="catalog">';
		echo '<div class="catalog__container">';
			echo '<div class="catalog__heading _content"> <h1>Каталог</h1> </div>';

			echo '<div class="catalog__main main-catalog">';
				echo '<div class="main-catalog__heading">';
					$terms = get_terms([
						'taxonomy'		=> 'category',
						'hide_empty'	=> true,
						'exclude'		=> 1,
						'orderby'		=> 'id',
						'order'			=> 'DESC',
					]);

					if ($terms) :
						echo '<div class="main-catalog__filter catalog-filter">';
							echo '<div class="catalog-filter__item" data-category="">';
								echo '<div class="checkbox">';
									echo '<input id="catalog-filter-0" class="checkbox__input" type="radio" value="Все" name="catalog-filter" checked>';
									echo '<label for="catalog-filter-0" class="checkbox__label"><span class="checkbox__text">Все</span></label>';
								echo '</div>';
							echo '</div>';

							$j = 1;
							foreach ($terms as $term) :
								echo '<div class="catalog-filter__item" data-category="'. $term->slug .'">';
									echo '<div class="checkbox">';
										echo '<input id="catalog-filter-'. $j .'" class="checkbox__input" type="radio" value="'. $term->name .'" name="catalog-filter">';
										echo '<label for="catalog-filter-'. $j .'" class="checkbox__label"><span class="checkbox__text">'. $term->name .'</span></label>';
									echo '</div>';
								echo '</div>';

								$j++;
							endforeach;
						echo '</div>';
					endif;

					echo '<div class="main-catalog__sorting">';
						echo '<select name="form[]" class="form sorting">';
							echo '<option value="ASC">Сначала дешевле</option>';
							echo '<option value="DESC">Сначала дороже</option>';
						echo '</select>';
					echo '</div>';
				echo '</div>';
				echo '<div class="main-catalog__body">';
					echo '<div class="main-catalog__articles">';
						$args = array(
							'post_type' => 'products',
							'posts_per_page' => -1,
							'meta_key'  => 'product-price',
							'orderby' => 'meta_value_num',
							'order'	=> 'ASC',
						);

						query_posts( $args );

						while (have_posts()) :
							the_post();
							$id = get_the_ID();
							$galleryProduct = get_field('gallery-product', $id);
							$productPrice = get_field('product-price', $id);
							$terms = wp_get_post_terms($id, 'category');

							echo '<article class="main-catalog__product main-product">';
								echo '<div class="main-product__heading">';
									echo '<a href="'. get_the_permalink() .'" class="main-product__title title-h4">'. get_the_title() .'</a>';
									echo '<div class="main-product__category">'. $terms[0]->name .'</div>';
								echo '</div>';
								echo '<a href="'. get_the_permalink() .'" class="main-product__image"><img src="'. $galleryProduct[0]['url'] .'" alt="'. $galleryProduct[0]['alt'] .'" loading="lazy"></a>';
								echo '<div class="main-product__footer">';
									echo '<div class="main-product__price title-h3">'. number_format($productPrice, 0, '', ' ') .' ₽</div>';
									echo '<div class="main-product__button"><button type="button" data-popup="#request" class="btn btn_green _hover-black"><span>Заказать</span></button></div>';
								echo '</div>';
							echo '</article>';
						endwhile;

						wp_reset_postdata();
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</section>';
echo '</main>';

get_footer();
