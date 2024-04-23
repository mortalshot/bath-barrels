<?php 
get_header(); 

echo '<main class="page">';
   echo '<section class="card-product">';
      echo '<div class="card-product__container">';
         echo '<h1 class="card-product__title">'. get_the_title() .'</h1>';

         $gallery = get_field('gallery-product');
         $productOptions = get_field('product-options');
         $productPrice = get_field('product-price');
         $tabs = get_field('card-product_tabs');

         echo '<div class="card-product__wrapper">';
            echo '<div class="card-product__main">';
               echo '<div class="card-product__gallery gallery-product" '. (count($gallery) <= 1 ? 'style="grid-template-columns: 1fr;"' : '') .'>';
                  if (count($gallery) > 1) :
                     echo '<div class="gallery-product__thumb swiper">';
                        echo '<div class="gallery-product__wrapper swiper-wrapper">';
                           foreach ($gallery as $image) :
                              echo '<div class="gallery-product__slide swiper-slide"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
                           endforeach;
                        echo '</div>';
                     echo '</div>';
                  endif;

                  echo '<div class="gallery-product__slider swiper">';
                     echo '<div class="gallery-product__wrapper swiper-wrapper" data-gallery>';
                        foreach ($gallery as $image) :
                           echo '<div class="gallery-product__slide swiper-slide" data-src="'. $image['url'] .'"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
                        endforeach;
                     echo '</div>';
                  echo '</div>';
               echo '</div>';

               if ($tabs) :
                  echo '<div data-tabs data-tabs-animate class="card-product__tabs tabs">';
                     echo '<nav data-tabs-titles class="tabs__navigation">';
                        $j = 0;
                        foreach ($tabs as $tab) :
                           echo '<button type="submit" class="tabs__title '. ($j == 0 ? '_tab-active' : '') .'">'. $tab['tabs_title'] .'</button>';
                           $j++;
                        endforeach;
                     echo '</nav>';
                     echo '<div data-tabs-body class="tabs__content">';
                        foreach ($tabs as $tab) :
                           $tabTitle = $tab['tabs_title'];
                           $tabContent = $tab['tabs_content'];

                           echo '<div class="tabs__body">';
                              if ($tabContent[0]['acf_fc_layout'] == "template1") :
                                 $text = $tabContent[0]['text'];

                                 echo '<div class="_content">';
                                    echo '<h4>'. $tabTitle .'</h4>';
                                    echo $text;
                                 echo '</div>';
                              elseif ($tabContent[0]['acf_fc_layout'] == "template2") :
                                 $table = $tabContent[0]['table'];

                                 echo '<div class="_content">';
                                    echo '<h4>'. $tabTitle .'</h4>';

                                    echo '<div class="wp-block-table">';
                                       echo '<table>';
                                          echo '<tbody>';
                                             foreach ($table['body'] as $tr) :
                                                echo '<tr>';
                                                   foreach ($tr as $td) :
                                                      echo '<td>'. $td['c'] .'</td>';
                                                   endforeach;
                                                echo '</tr>';
                                             endforeach;
                                          echo '</tbody>';
                                       echo '</table>';
                                    echo '</div>';
                                 echo '</div>';
                              endif;
                           echo '</div>';
                        endforeach;
                     echo '</div>';
                  echo '</div>';
               endif;

               if ($productOptions) :
                  echo '<div class="card-product__options product-options" data-da=".card-product__wrapper, 767.98, last">';
                     $j = 1;
                     foreach ($productOptions as $item) :
                        $itemCaption = $item['product-options_caption'];
                        $itemRowsSelect = $item['product-options_select'];
                        $itemRows = $item['product-options_row'];

                        if ($itemRowsSelect == "Выбор одной опции из множества") :
                           $type = "radio";
                        elseif($itemRowsSelect == "Множественный выбор") :
                           $type = "checkbox";
                        endif;

                        $xsColumns = $item['options-column-xs'];
                        $smColumns = $item['options-column-sm'];
                        $mdColumns = $item['options-column-md'];
                        $lgColumns = $item['options-column-lg'];
                        $deskColumns = $item['options-column'];
                        
                        if ($xsColumns == "50%") :
                           $xsClass = "col-6";
                        elseif ($xsColumns == "33%") :
                           $xsClass = "col-4";
                        elseif ($xsColumns == "16%") :
                           $xsClass = "col-2";
                        endif;

                        if ($smColumns == "50%") :
                           $smClass = "col-sm-6";
                        elseif ($smColumns == "33%") :
                           $smClass = "col-sm-4";
                        elseif ($smColumns == "16%") :
                           $smClass = "col-sm-2";
                        endif;

                        if ($mdColumns == "50%") :
                           $mdClass = "col-md-6";
                        elseif ($mdColumns == "33%") :
                           $mdClass = "col-md-4";
                        elseif ($mdColumns == "16%") :
                           $mdClass = "col-md-2";
                        endif;

                        if ($lgColumns == "50%") :
                           $lgClass = "col-lg-6";
                        elseif ($lgColumns == "33%") :
                           $lgClass = "col-lg-4";
                        elseif ($lgColumns == "16%") :
                           $lgClass = "col-lg-2";
                        endif;

                        echo '<div class="product-options__item">';
                           echo '<div class="product-options__caption">';
                              echo '<div class="title-h4">'. $itemCaption .'</div>';
                              echo '<div class="product-options__total">+ <span>0</span> ₽</div>';
                           echo '</div>';
      
                           echo '<div class="product-options__row product-options__row_'. $type .'">';
                              echo '<div class="form__row">';
                                 $k = 1;
                                 foreach ($itemRows as $row) :
                                    $option = $row['product-options_option'];
                                    $price = $row['product-options_price'];

                                    $optionTitle = get_the_title($option);
                                    $optionTemplate = get_field('product-options_template', $option);
                                    $optionImage = get_field('product-options_image', $option);
                                    $optionPrice = get_field('product-options_price', $option);

                                    echo '<div class="form__item '. $xsClass . ' ' . $smClass . ' ' . $mdClass . ' ' . $lgClass .'">';
                                       echo '<div class="product-options__option product-options__option_'. $type . ' ' . ($optionTemplate == 'Шаблон 2' ? 'product-options__option_bg' : '') .'" data-price="'. $optionPrice .'">';
                                          echo '<input id="product-options-'. $j . '-' . $k .'" class="product-options__input" type="'. $type .'" value="'. $optionTitle .'" name="product-options-'. $j .'">';
                                          echo '<label for="product-options-'. $j . '-' . $k .'" class="product-options__label">';
                                             echo '<div class="product-options__name">'. $optionTitle .'</div>';
                                             echo $optionImage != '' ? '<div class="product-options__image"><img src="'. $optionImage['url'] .'" alt="'. $optionImage['alt'] .'" loading="lazy"></div>' : '';
                                             echo '<div class="product-options__price title-h4">+ '. number_format($optionPrice, 0, '', ' ') .' ₽</div>';
                                          echo '</label>';
                                       echo '</div>';
                                    echo '</div>';

                                    $k++;
                                 endforeach;
                              echo '</div>';
                           echo '</div>';
                        echo '</div>';

                        $j++;
                     endforeach;


                     $delivery = get_field('delivery', 'options');
                     $deliveryCaption = $delivery['caption'];
                     $deliveryItems = $delivery['delivery_items'];
                     echo '<div class="product-options__item">';
                        echo '<div class="product-options__caption">';
                           echo '<div class="title-h4">'. $deliveryCaption .'</div>';
                           echo '<div class="product-options__total">+ <span>0</span> ₽</div>';
                        echo '</div>';

                        echo '<div class="product-options__row product-options__row_radio">';
                           echo '<div class="form__row">';
                              $k = 1;
                              foreach ($deliveryItems as $item) :
                                 $image = $item['image'];
                                 $name = $item['name'];
                                 $price = $item['price'];

                                 echo '<div class="form__item col-6">';
                                    echo '<div class="product-options__option product-options__option_radio" data-price="'.  number_format(intval($price), 0, '', '') .'">';
                                       echo '<input id="product-options-'. ($j+1) . '-' . $k .'" class="product-options__input" type="'. $type .'" value="'. $name .'" name="product-options-'. ($j+1) .'">';
                                       echo '<label for="product-options-'. ($j+1) . '-' . $k .'" class="product-options__label">';
                                          echo '<div class="product-options__name">'. $name .'</div>';
                                          echo '<div class="product-options__image"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
                                          echo '<div class="product-options__price title-h4">+ '. $price .'</div>';
                                       echo '</label>';
                                    echo '</div>';
                                 echo '</div>';
                                 
                                 $k++;
                              endforeach;
                           echo '</div>';
                        echo '</div>';
                     echo '</div>';
                  echo '</div>';
               endif;
            echo '</div>';

            echo '<div class="card-product__sidebar product-sidebar">';
               echo '<div class="product-sidebar__price-list price-list">';
                  echo '<div class="price-list__row price-list__row_main">';
                     echo '<div class="price-list__caption">Наименование</div>';
                     echo '<ul>';
                        echo '<li>';
                           echo '<div class="price-list__name">'. get_the_title() .'</div>';
                           echo '<div class="price-list__price"><span>'. number_format(intval($productPrice), 0, '', ' ') .'</span> ₽</div>';
                        echo '</li>';
                     echo '</ul>';
                  echo '</div>';
                  echo '<div class="price-list__options"></div>';
                  echo '<div class="price-list__row price-list__row_adds">';
                     echo '<div class="price-list__caption">Дополнительные опции</div>';
                     echo '<ul></ul>';
                  echo '</div>';
               echo '</div>';
               echo '<div class="product-sidebar__summary">';
                  echo '<div>Итого</div>';
                  echo '<div class="title-h3"><span>'. number_format(intval($productPrice), 0, '', ' ') .'</span> ₽</div>';
               echo '</div>';
               echo do_shortcode('[contact-form-7 id="443" title="Заказать продукт"]');
            echo '</div>';
         echo '</div>';

         echo '<a href="" data-goto=".product-sidebar" data-goto-top="90" class="to-sidebar btn btn_green"><span>Заказать</span></a>';
      echo '</div>';
   echo '</section>';
echo '</main>';

get_footer();