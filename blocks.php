<?php
if (have_rows('all_blocks')) :
   $i = 1;
   while (have_rows('all_blocks')) : the_row();
      if (get_row_layout() == 'template1') :
         $bg = get_sub_field('banner_bg');
         $text = get_sub_field('banner_text');
         $button = get_sub_field('banner_button');
         $locationText = get_sub_field('banner_location-text');
         $featuresBanner = get_sub_field('features-banner');

         echo '<section id="banner-' . $i . '" class="banner">';
            echo '<div class="banner__container">';
               echo '<div class="banner__main main-banner">';
                  echo '<img src="' . $bg['url'] . '" alt="' . $bg['alt'] . '" class="main-banner__bg" loading="lazy">';

                  echo '<div class="main-banner__wrapper">';
                     echo '<div class="main-banner__body">';
                        echo '<div class="main-banner__text _content">' . $text . '</div>';
                        echo '<div class="main-banner__button"> <button type="button" class=" btn btn_green _hover-white" data-popup="#request"><span>' . $button . '</span></button> </div>';
                     echo '</div>';

                     echo '<div class="main-banner__location location-banner">';
                        echo '<img src="' . get_template_directory_uri() . '/dist/img/home/location-banner.svg" alt="" loading="lazy">';

                        echo '<div class="location-banner__body">';
                           echo '<div class="location-banner__caption">Мы находимся</div>';
                           echo '<div class="location-banner__text">' . $locationText . '</div>';
                        echo '</div>';
                     echo '</div>';
                  echo '</div>';
               echo '</div>';

               if ($featuresBanner) :
                  echo '<div class="banner__features features-banner">';
                     foreach ($featuresBanner as $feature) :
                        $featureIcon = $feature['icon'];
                        $featureText = $feature['text'];

                        echo '<div class="features-banner__item">';
                           echo '<img src="' . $featureIcon['url'] . '" alt="' . $featureIcon['alt'] . '" loading="lazy">';
                           echo '<span>' . $featureText . '</span>';
                        echo '</div>';
                     endforeach;
                  echo '</div>';
               endif;
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template2') :
         $heading = get_sub_field('categories-widget_heading');
         $list = get_sub_field('categories-widget_list');

         echo '<section id="categories-widget-' . $i . '" class="categories-widget">';
            echo '<div class="categories-widget__container">';
               echo $heading != '' ? '<div class="categories-widget__heading _content">' . $heading . '</div>' : '';

               echo '<div class="categories-widget__list">';
                  foreach ($list as $item) :
                     $category = $item['categories-widget_item'];
                     $termId = $category->term_id;
                     $termName = $category->name;
                     $image = get_field('preview', 'category_' . $termId);


                     echo '<div class="categories-widget__item category-item">';
                        echo '<a href="'. get_term_link($termId) .'" class="category-item__wrapper">';
                           echo '<div class="category-item__img"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
                           echo '<div class="category-item__link _hover-black"><span>'. $termName .'</span></div>';
                        echo '</a>';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template3') :
         $heading = get_sub_field('information_heading');
         $tabs = get_sub_field('information_tabs');

         echo '<section id="information-' . $i . '" class="information">';
            echo '<div class="information__container">';
               echo $heading != '' ? '<div class="information__heading _content">' . $heading . '</div>' : '';

               echo '<div data-tabs data-tabs-animate class="information__tabs tabs">';
                  echo '<nav data-tabs-titles class="tabs__navigation" '. (count($tabs) < 6 ? 'style="justify-content: flex-start;"' : '') .'>';
                     $j = 0;
                     foreach ($tabs as $item) :
                        $button = $item['tabs_button'];
                        echo '<button type="submit" class="information__title _icon-' . $button['tabs_title-icon'] . ' tabs__title ' . ($j < 1 ? '_tab-active' : '') . '">' . $button['tabs_title'] . '</button>';

                        $j++;
                     endforeach;
                  echo '</nav>';

                  echo '<div data-tabs-body class="tabs__content">';
                     foreach ($tabs as $item) :
                        $template = $item['information-template'];
                        if ($template == "Шаблон 1") :
                           $templateClass = "information-template_first";
                        elseif ($template == "Шаблон 2") :
                           $templateClass = "information-template_second";
                        elseif ($template == "Шаблон 3") :
                           $templateClass = "information-template_third";
                        elseif ($template == "Шаблон 4") :
                           $templateClass = "information-template_fourth";
                        endif;

                        $templateImage = $item['information-template_image'];
                        $templateItems = $item['information-template_items'];

                        echo '<div class="tabs__body">';
                           echo '<div class="information__template information-template '. $templateClass .'">';
                              if ($template == "Шаблон 1") :
                                 echo '<div class="information-template__column">';
                                    echo '<div class="information-template__image"> <img src="'. $templateImage['url'] .'" alt="'. $templateImage['alt'] .'" loading="lazy"> </div>';

                                    echo '<div class="information-template__card">';
                                       echo '<div class="information-template__wrapper">';
                                          echo '<div class="information-template__count">01</div>';
                                          echo '<div class="information-template__text _content">'. $templateItems[0]['Text'] .'</div>';
                                       echo '</div>';
                                    echo '</div>';
                                 echo '</div>';

                                 $j = 1;
                                 foreach ($templateItems as $card) :
                                    if ($j > 1) :
                                       $cardText = $card['Text'];
                                       echo '<div class="information-template__card">';
                                          echo '<div class="information-template__wrapper">';
                                             echo '<div class="information-template__count">'. ($j <= 9 ? '0' : '') . $j .'</div>';
                                             echo '<div class="information-template__text _content">'. $cardText .'</div>';
                                          echo '</div>';
                                       echo '</div>';
                                    endif;

                                    $j++;
                                 endforeach;
                              elseif ($template == "Шаблон 2") :
                                 echo '<div class="information-template__image"> <img src="'. $templateImage['url'] .'" alt="'. $templateImage['alt'] .'" loading="lazy"> </div>';

                                 $j = 1;
                                 foreach ($templateItems as $card) :
                                    $cardText = $card['Text'];

                                    echo '<div class="information-template__card" '. (count($templateItems) == 3 && $j == count($templateItems) ? 'style="grid-column: span 2;"' : '') .'>';
                                       echo '<div class="information-template__wrapper">';
                                          echo '<div class="information-template__count">'. ($j <= 9 ? '0' : '') . $j .'</div>';
                                          echo '<div class="information-template__text _content">'. $cardText .'</div>';
                                       echo '</div>';
                                    echo '</div>';

                                    $j++;
                                 endforeach;
                              elseif ($template == "Шаблон 3") :
                                 $j = 1;
                                 foreach ($templateItems as $card) :
                                    $cardText = $card['Text'];
                                    $cardImage = $card['Image'];

                                    echo '<div class="information-template__column">';
                                       echo '<div class="information-template__card">';
                                          echo '<div class="information-template__wrapper">';
                                             echo '<div class="information-template__count">'. ($j <= 9 ? '0' : '') . $j .'</div>';
                                             echo '<div class="information-template__text _content">'. $cardText .'</div>';
                                          echo '</div>';
                                       echo '</div>';
                                       echo '<div class="information-template__image"> <img src="'. $cardImage['url'] .'" alt="'. $cardImage['alt'] .'" loading="lazy"> </div>';
                                    echo '</div>';

                                    $j++;
                                 endforeach;
                              elseif ($template == "Шаблон 4") :
                                 foreach ($templateItems as $card) :
                                    $cardText = $card['Text'];

                                    echo '<div class="information-template__card">';
                                       echo '<div class="information-template__wrapper">';
                                          echo '<div class="information-template__icon"><img src="' . get_template_directory_uri() . '/dist/img/icons/accept.svg" alt="" loading="lazy"></div>';
                                          echo '<div class="information-template__text _content">'. $cardText .'</div>';
                                       echo '</div>';
                                    echo '</div>';
                                 endforeach;
                              endif;
                           echo '</div>';
                        echo '</div>';
                     endforeach;
                  echo '</div>';
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template4') :
         $heading = get_sub_field('features_heading');
         $list = get_sub_field('features_list');
         $image = get_sub_field('features_image');

         echo '<section id="features-' . $i . '" class="features">';
            echo '<div class="features__container">';
               echo '<div class="features__main">';
                  echo '<div class="features__heading _content">'. $heading .'</div>';

                  if ($list) :
                     echo '<div class="features__list">';
                        foreach ($list as $item) :
                           $itemIcon = $item['icon'];
                           $itemText = $item['text'];

                           echo '<div class="features__item features-item">';
                              echo '<div class="features-item__icon"><img src="'. $itemIcon['url'] .'" alt="'. $itemIcon['alt'] .'" loading="lazy"></div>';
                              echo '<div class="features-item__text">'. $itemText .'</div>';
                           echo '</div>';
                        endforeach;
                     echo '</div>';
                  endif;
               echo '</div>';
               echo '<div class="features__image"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template5') :
         $title = get_sub_field('manufacturers_title');
         $slider = get_sub_field('manufacturers_slider');
         $text = get_sub_field('manufacturers_text');
         $features = get_sub_field('manufacturers_features');

         echo '<section id="manufacturers-' . $i . '" class="manufacturers">';
            echo '<div class="manufacturers__container">';
               echo '<div class="manufacturers__heading">';
                  echo '<h2 class="manufacturers__title">'. $title .'</h2>';
                  echo '<div class="swiper__arrows">';
                     echo '<button class="swiper__arrow swiper__arrow_left _hover-green"><i class="_icon-arrow"></i></button>';
                     echo '<button class="swiper__arrow swiper__arrow_right _hover-green"><i class="_icon-arrow"></i></button>';
                  echo '</div>';
               echo '</div>';

               echo '<div class="manufacturers__row">';
						echo '<div class="manufacturers__slider swiper">';
							echo '<div class="manufacturers__wrapper swiper-wrapper" data-gallery>';
                        foreach ($slider as $image) :
                           echo '<div data-src="'. $image['url'] .'" class="manufacturers__slide swiper-slide"><img src="'. $image['url'] .'" alt="" loading="lazy"></div>';
                        endforeach;
							echo '</div>';
							echo '<div class="swiper-pagination"></div>';
						echo '</div>';
						echo '<div class="manufacturers__body">';
							echo '<div class="manufacturers__text _content">'. $text .'</div>';

                     if ($features) :
                        echo '<div class="manufacturers__features">';
                           foreach ($features as $item) :
                              echo '<div class="manufacturers-feature">';
                                 echo '<div class="manufacturers-feature__val">'. $item['val'] .'</div>';
                                 echo '<div class="manufacturers-feature__text">'. $item['text'] .'</div>';
                              echo '</div>';
                           endforeach;
                        echo '</div>';
                     endif;
						echo '</div>';
					echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template6') :
         $heading = get_sub_field('template6_heading');
         $items = get_sub_field('template6_items');
         $accent = get_sub_field('template6_accent');
         $features = get_sub_field('template6_features');

         echo '<section id="template6-' . $i . '" class="template6">';
            echo '<div class="template6__container">';
               echo $heading != '' ? '<div class="template6__heading _content">' . $heading . '</div>' : '';
               
               echo '<div class="template6__items">';
                  foreach ($items as $item) :
                     $itemBg = $item['bg'];
                     $itemText = $item['text'];

                     echo '<div class="template6__item">';
                        echo '<img src="'. $itemBg['url'] .'" alt="'. $itemBg['alt'] .'" class="template6__item-bg">';
                        echo '<div class="title-h4">'. $itemText .'</div>';
                     echo '</div>';
                  endforeach;
               echo '</div>';

               echo '<div class="template6__row">';
						echo '<div class="template6__blank"></div>';
						echo '<div class="template6__main">';
							echo '<div class="template6__accent">'. $accent .'</div>';

							echo '<div class="template6__features">';
                        foreach ($features as $feature) :
                           $featureIcon = $feature['icon'];
                           $featureText = $feature['text'];

                           echo '<div class="template6__feature">';
                              echo '<div class="template6__feature-icon"><img src="'. $featureIcon['url'] .'" alt="'. $featureIcon['alt'] .'" loading="lazy"></div>';
                              echo '<div class="template6__feature-text _content">'. $featureText .'</div>';
                           echo '</div>';
                        endforeach;
							echo '</div>';
						echo '</div>';
					echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template7') :
         $title = get_sub_field('template7_title');
         $text = get_sub_field('template7_text');
         $button = get_sub_field('template7_button');
         $image = get_sub_field('template7_image');

         echo '<section id="template7-' . $i . '" class="template7">';
            echo '<div class="template7__container">';
               echo '<div class="template7__wrapper">';
						echo '<div class="template7__main">';
							echo '<div class="template7__body">';
                        echo $title != '' ? '<h2 class="template7__title">' . $title . '</h2>' : '';
                        echo $text != '' ? '<div class="template7__text _content">' . $text . '</div>' : '';
							echo '</div>';
							echo '<div class="template7__button"><button type="button" data-popup="#request" class="btn btn_green _hover-black"><span>'. $button .'</span></button></div>';
						echo '</div>';
						echo '<div class="template7__image"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
					echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template8') :
         $title = get_sub_field('title');
         $image = get_sub_field('image');

         echo '<section id="template8-' . $i . '" class="template8">';
            echo '<div class="template8__container">';
               echo $title != '' ? '<h2 class="template8__title">' . $title . '</h2>' : '';
               echo '<div class="template8__image"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template9') :
         $steps = get_sub_field('steps');
         $contacts = get_field('contacts', 'options');
         $phone = $contacts['contacts_phone'];
         $phonePreg =  preg_replace("/[^0-9]/", '', $phone);
         $telegram = $contacts['telegram'];
         $whatsapp = $contacts['whatsapp'];

         echo '<section id="steps-' . $i . '" class="steps">';
            echo '<div class="steps__container">';
               echo '<div data-tabs="767.98" data-tabs-animate="" class="steps__tabs tabs">';
                  echo '<nav data-tabs-titles class="tabs__navigation">';
                     $j = 1;
                     foreach ($steps as $item) :
                        echo '<button type="submit" class="tabs__title '. ($j == 1 ? '_tab-active' : '') .'">'. ($j <= 9 ? '0' : '') . $j . ' ' . $item['title'] .'</button>';
                        $j++;
                     endforeach;
                  echo '</nav>';
                  echo '<div data-tabs-body class="tabs__content">';
                     $j = 1;
                     foreach ($steps as $item) :
                        $title = $item['title'];
                        $text = $item['text'];
                        $icon = $item['icon'];

                        echo '<div class="tabs__body">';
                           echo '<div class="steps__row">';
                              echo '<div class="steps__main">';
                                 echo '<div class="steps__body">';
                                    echo '<div class="steps__heading">';
                                       echo '<h4 class="steps__title">'. $title .'</h4>';
                                       echo '<div class="steps__step">Шаг '. ($j <= 9 ? '0' : '') . $j . '</div>';
                                    echo '</div>';
                                    echo '<div class="steps__text _content">'. $text .'</div>';
                                 echo '</div>';
   
                                 echo '<div class="steps__contacts contact-steps">';
                                    echo '<a href="tel:+'. $phonePreg .'" class="contact-steps__item"><span>'. $phone .'</span></a>';
                                    echo $telegram != '' ? '<a href="'. $telegram .'" class="contact-steps__item"><i class="_icon-telegram"></i></a>' : '';
                                    echo $whatsapp != '' ? '<a href="'. $whatsapp .'" class="contact-steps__item"><i class="_icon-whatsapp"></i></a>' : '';
                                 echo '</div>';
                              echo '</div>';
                              echo '<div class="steps__icon"><img src="'. $icon['url'] .'" alt="'. $icon['alt'] .'" loading="lazy"></div>';
                           echo '</div>';
                        echo '</div>';

                        $j++;
                     endforeach;
                  echo '</div>';
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template10') :
         $title = get_field('cases_title', 'options');
         $slider = get_field('cases_slider', 'options');
         $contacts = get_field('contacts', 'options');
         $phone = $contacts['contacts_phone'];
         $phonePreg =  preg_replace("/[^0-9]/", '', $phone);
         $telegram = $contacts['telegram'];
         $whatsapp = $contacts['whatsapp'];

         echo '<section id="cases-' . $i . '" class="cases">';
            echo '<div class="cases__container">';
               echo '<div class="cases__heading">';
                  echo '<h2 class="cases__title">'. $title .'</h2>';
                  echo '<div class="swiper__arrows">';
                     echo '<button class="swiper__arrow swiper__arrow_left _hover-green"><i class="_icon-arrow"></i></button>';
                     echo '<button class="swiper__arrow swiper__arrow_right _hover-green"><i class="_icon-arrow"></i></button>';
                  echo '</div>';
               echo '</div>';
               echo '<div class="cases__slider swiper">';
                  echo '<div class="cases__wrapper swiper-wrapper">';
                     foreach ($slider as $case) :
                        $caseTitle = $case['case_title'];
                        $caseOptions = $case['options-case'];
                        $caseGallery = $case['cases_gallery'];
                        $caseBenefit = $case['case_benefit'];
                        $caseFeature1 = $case['case_feature_first'];
                        $caseFeature2 = $case['case_feature_second'];

                        echo '<div class="cases__slide swiper-slide case">';
                           echo '<div class="case__row">';
                              echo $caseBenefit != '' ? '<div class="case__benefit case__card title-h3">'. $caseBenefit .'</div>' : '';
                              echo '<div class="case__feature case__feature_first case__card">';
                                 echo '<div class="case__feature-icon"><img src="'. get_template_directory_uri() .'/dist/img/icons/accept.svg" alt="" loading="lazy"></div>';
                                 echo '<div class="case__feature-text _content">'. $caseFeature1 .'</div>';
                              echo '</div>';
                              echo '<div class="case__feature case__feature_second case__card">';
                                 echo '<div class="case__feature-icon"><img src="'. get_template_directory_uri() .'/dist/img/icons/accept.svg" alt="" loading="lazy"></div>';
                                 echo '<div class="case__feature-text _content">'. $caseFeature2 .'</div>';
                              echo '</div>';
                              echo '<div class="case__main case__card">';
                                 echo '<div class="case__title">'. $caseTitle .'</div>';
   
                                 echo '<div class="case__contacts contact-steps">';
                                    echo '<a href="tel:+'. $phonePreg .'" class="contact-steps__item"><span>'. $phone .'</span></a>';
                                    echo $telegram != '' ? '<a href="'. $telegram .'" class="contact-steps__item"><i class="_icon-telegram"></i></a>' : '';
                                    echo $whatsapp != '' ? '<a href="'. $whatsapp .'" class="contact-steps__item"><i class="_icon-whatsapp"></i></a>' : '';
                                 echo '</div>';
   
                                 if ($caseOptions) :
                                    echo '<div class="case__options options-case">';
                                       foreach ($caseOptions as $column) :
                                          $items = $column['options-case_items'];
                                          
                                          echo '<div class="options-case__column">';
                                             foreach ($items as $item) :
                                                echo '<div class="options-case__item">';
                                                   echo '<div>'. $item['attr'] .'</div>';
                                                   echo '<div>'. $item['val'] .'</div>';
                                                echo '</div>';
                                             endforeach;
                                          echo '</div>';
                                       endforeach;
                                    echo '</div>';
                                 endif;
   
                                 if ($caseGallery) :
                                    echo '<div class="case__gallery swiper">';
                                       echo '<div class="case__wrapper swiper-wrapper" data-gallery>';
                                          foreach ($caseGallery as $image) :
                                             echo '<div data-src="'. $image['url'] .'" class="case__slide swiper-slide"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
                                          endforeach;
                                       echo '</div>';
      
                                       echo '<div class="swiper-pagination"></div>';
                                    echo '</div>';
                                 endif;
                              echo '</div>';
                           echo '</div>';
                        echo '</div>';
                     endforeach;
                  echo '</div>';
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template11') :
         $title = get_field('faq_text', 'options');
         $spollers = get_field('faq_spollers', 'options');

         echo '<section id="faq-' . $i . '" class="faq">';
            echo '<div class="faq__container">';
               echo '<div class="faq__row">';
                  echo '<div class="faq__text _content">'. $title .'</div>';
                  echo '<div data-spollers class="faq__spollers spollers">';
                     $j = 0;
                     foreach ($spollers as $item) :
                        $question = $item['spollers_title'];
                        $answer = $item['spollers_body'];

                        echo '<div class="spollers__item">';
                           echo '<button type="button" data-spoller class="spollers__title '. ($j == 0 ? '_spoller-active' : '') .'"><span>'. $question .'</span></button>';
                           echo '<div class="spollers__body">';
                              echo '<div class="_content">'. $answer .'</div>';
                           echo '</div>';
                        echo '</div>';


                        $j++;
                     endforeach;
                  echo '</div>';
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template12') :
         $title = get_sub_field('template12_title');
         $contacts = get_field('contacts', 'options');
         $phone = $contacts['contacts_phone'];
         $phonePreg =  preg_replace("/[^0-9]/", '', $phone);
         $mail = $contacts['contacts_mail'];
         $address = $contacts['contacts_address'];
         $mapDesk = $contacts['map-desk'];
         $mapMob = $contacts['map-mob'];
         $telegram = $contacts['telegram'];
         $whatsapp = $contacts['whatsapp'];

         echo '<section id="maps-' . $i . '" class="maps">';
            echo '<div class="maps__container">';
               echo '<div class="maps__wrapper">';
                  echo '<div class="maps__top">';
                     echo '<h2 class="maps__title">'. $title .'</h2>';

                     echo '<div class="maps__contacts contacts">';
                        echo '<div class="contacts__item"><a href="tel:+'. $phonePreg .'">'. $phone .'</a></div>';
                        echo '<div class="contacts__item"><a href="mailto:'. $mail .'">'. $mail .'</a></div>';
                        echo '<div class="contacts__item"><a href="'. $address['url'] .'" target="'. $address['target'] .'">'. $address['title'] .'</a></div>';
                        
                        echo '<div class="contact-steps">';
                           echo '<div class="contact-steps__item">';
                              echo '<button type="button" class="btn" data-popup="#request">';
                                 echo '<i class="_icon-calculator"></i>';
                                 echo '<span>' . $button . '</span>';
                              echo '</button>';
                           echo '</div>';
                           echo $telegram != '' ? '<a href="'. $telegram .'" class="contact-steps__item"><i class="_icon-telegram"></i></a>' : '';
                           echo $whatsapp != '' ? '<a href="'. $whatsapp .'" class="contact-steps__item"><i class="_icon-whatsapp"></i></a>' : '';
                        echo '</div>';
                     echo '</div>';
                  echo '</div>';

                  echo '<a href="'. $address['url'] .'" target="_blank" class="maps__map">';
                     echo '<picture>';
                        echo '<source srcset="'. $mapDesk['url'] .'" media="(min-width: 768.98px)">';
                        echo '<img src="'. $mapMob['url'] .'" alt="" loading="lazy">';
                     echo '</picture>';
                  echo '</a>';
                  echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template13') :
         $heading = get_sub_field('template13_heading');
         $text = get_sub_field('template13_text');
         $image = get_sub_field('template13_image');

         echo '<section id="template13-' . $i . '" class="template13">';
            echo '<div class="template13__container">';
               echo '<div class="template13__row">';
                  echo '<div class="template13__body">';
                     echo '<div class="template13__heading _content">'. $heading .'</div>';
                     echo $text != '' ? '<div class="template13__text _content">' . $text . '</div>' : '';
                  echo '</div>';
                  echo '<div class="template13__image"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template14') :
         $heading = get_field('delivery_heading', 'options');
         $payment = get_field('payment', 'options');
         $paymentCaption = $payment['caption'];
         $paymentText = $payment['text'];
         $delivery = get_field('delivery', 'options');
         $deliveryCaption = $delivery['caption'];
         $deliveryItems = $delivery['delivery_items'];
         $contacts = get_field('contacts', 'options');
         $phone = $contacts['contacts_phone'];
         $phonePreg =  preg_replace("/[^0-9]/", '', $phone);
         $telegram = $contacts['telegram'];
         $whatsapp = $contacts['whatsapp'];

         echo '<section id="delivery-' . $i . '" class="delivery">';
            echo '<div class="delivery__container">';
               echo $heading != '' ? '<div class="delivery__heading _content">' . $heading . '</div>' : '';

               echo '<div class="delivery__card payment">';
                  echo '<h3 class="delivery__caption">'. $paymentCaption .'</h3>';

                  echo '<div class="payment__body">';
                     echo '<div class="payment__text _content">'. $paymentText .'</div>';

                     echo '<div class="payment__contacts contact-steps">';
                        echo '<div class="contact-steps__item">';
                           echo '<button type="button" class="btn" data-popup="#request">';
                              echo '<i class="_icon-calculator"></i>';
                              echo '<span>Заказать рассчёт</span>';
                           echo '</button>';
                        echo '</div>';
								echo $telegram != '' ? '<a href="'. $telegram .'" class="contact-steps__item"><i class="_icon-telegram"></i></a>' : '';
								echo $whatsapp != '' ? '<a href="'. $whatsapp .'" class="contact-steps__item"><i class="_icon-whatsapp"></i></a>' : '';
                     echo '</div>';
                  echo '</div>';
               echo '</div>';

               echo '<div class="delivery__card">';
                  echo '<h3 class="delivery__caption">'. $deliveryCaption .'</h3>';

                  if ($deliveryItems) :
                     echo '<div class="delivery__items">';
                        foreach ($deliveryItems as $item) :
                           $image = $item['image'];
                           $name = $item['name'];
                           $price = $item['price'];


                           echo '<div class="delivery__item delivery-item">';
                              echo '<div class="delivery-item__image"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
                              echo '<div class="delivery-item__footer">';
                                 echo '<div class="delivery-item__name">'. $name .'</div>';
                                 echo '<div class="delivery-item__price title-h4">'. $price .'</div>';
                              echo '</div>';
                           echo '</div>';
                        endforeach; 
                     echo '</div>';
                  endif;
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif (get_row_layout() == 'template0') :
         $title = get_sub_field('template0_title');

         echo '<section id="template0-' . $i . '" class="template0">';
            echo '<div class="template0__container">';
               echo $title != '' ? '<h2 class="template0__title">' . $title . '</h2>' : '';
            echo '</div>';
         echo '</section>';
      endif;
      $i++;
   endwhile;
endif;
if (get_the_content()) :
   echo '<section id="wp-content" class="wp-content">';
      echo '<div class="wp-content__container">';
         echo '<h1 class="wp-content__title">'. get_the_title() .'</h1>';

         echo '<div class="wp-content__wrapper _content">';
            the_content();
         echo '</div>';
      echo '</div>';
   echo '</section>';
endif;
