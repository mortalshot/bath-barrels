<?php 
get_header(); 

echo '<main class="page">';
   echo '<section class="error" data-fullscreen>';
      echo '<div class="error__container">';
         $errorImage = get_field('error_image', 'options');
         $errorTitle = get_field('error_title', 'options');
         $errorLink = get_field('error_link', 'options');

         echo '<div class="error__image"><img src="'. $errorImage['url'] .'" alt="'. $errorImage['alt'] .'" loading="lazy"></div>';
         echo '<div class="error__body">';
            echo '<h1 class="error__title">'. $errorTitle .'</h1>';
            echo '<a href="'. $errorLink['url'] .'" class="error__link" target="'. $errorLink['target'] .'">'. $errorLink['title'] .'</a>';
         echo '</div>';
      echo '</div>';
   echo '</section>';
echo '</main>';

get_footer();
