<?php 
			echo '<footer class="footer">';
				echo '<div class="footer__container">';
					echo '<div class="footer__row">';
						echo '<div class="footer__left">';
							echo '<a href="'. get_home_url() .'" class="footer__logo logo">';
								echo '<div class="logo__img">';
									include 'parts/logo.php';
								echo '</div>';
								echo '<div class="logo__text">Бани <br> бочки</div>';
							echo '</a>';
						echo '</div>';
						echo '<div class="footer__middle">';
							$footerMenu = get_field('footer-menu', 'options');

							echo '<nav class="footer__menu">';
								foreach ($footerMenu as $column) :
									$menuCaption = $column['menu-caption'];
									$menu = $column['menu'];

									echo '<div class="footer__menu-column">';
										echo '<a href="'. $menuCaption['url'] .'" target="'. $menuCaption['target'] .'">'. $menuCaption['title'] .'</a>';
										echo '<ul>';
											foreach ($menu as $item) :
												echo '<li><a href="'. $item['menu_link']['url'] .'" target="'. $item['menu_link']['target'] .'">'. $item['menu_link']['title'] .'</a></li>';
											endforeach;
										echo '</ul>';
									echo '</div>';
								endforeach;
							echo '</nav>';
						echo '</div>';
						echo '<div class="footer__right">';
							$contacts = get_field('contacts', 'options');
							$phone = $contacts['contacts_phone'];
							$phonePreg =  preg_replace("/[^0-9]/", '', $phone);
							$mail = $contacts['contacts_mail'];
							$address = $contacts['contacts_address'];
							$telegram = $contacts['telegram'];
							$whatsapp = $contacts['whatsapp'];

							echo '<div class="contact-steps">';
								echo $telegram != '' ? '<a href="'. $telegram .'" class="contact-steps__item"><i class="_icon-telegram"></i></a>' : '';
								echo $whatsapp != '' ? '<a href="'. $whatsapp .'" class="contact-steps__item"><i class="_icon-whatsapp"></i></a>' : '';

								echo '<button type="button" data-popup="#request" class="btn btn_border">';
									echo '<span>Заказать рассчёт</span>';
									echo '<i class="_icon-calculator"></i>';
								echo '</button>';
							echo '</div>';
							echo '<div class="contacts">';
								echo '<div class="contacts__item contacts__item_phone"><a href="tel:+'. $phonePreg .'">'. $phone .'</a></div>';
								echo '<div class="contacts__item contacts__item_mail"><a href="mailto:'. $mail .'">'. $mail .'</a></div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</footer>';

			echo '<div class="modals">';
				echo '<div id="request" aria-hidden="true" class="popup popup_calculation calculation">';
					echo '<div class="popup__wrapper">';
						echo '<div class="popup__content">';
							echo '<button data-close type="button" class="popup__close"><img src="'. get_template_directory_uri() .'/dist/img/icons/close.svg" alt="" loading="lazy"></button>';
							echo '<div class="popup__text">';
								echo do_shortcode('[contact-form-7 id="9" title="Заказать рассчёт"]');
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		wp_footer();
	echo '</body>';
echo '</html>';
