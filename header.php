<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php 
	wp_body_open();
	
	echo '<div class="wrapper">';
		echo '<header class="header _header-show" data-scroll="90" data-scroll-show>';
			echo '<div class="header__container">';
				echo '<div class="header__left">';
					echo '<div class="header__menu menu">';
						?>
						<button type="button" class="menu__icon icon-menu _hover-black">
							<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M4.58366 5.50002C5.08992 5.50002 5.50033 5.08961 5.50033 4.58335C5.50033 4.07709 5.08992 3.66669 4.58366 3.66669C4.0774 3.66669 3.66699 4.07709 3.66699 4.58335C3.66699 5.08961 4.0774 5.50002 4.58366 5.50002Z" stroke="#2D322F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M11.0003 5.50002C11.5066 5.50002 11.917 5.08961 11.917 4.58335C11.917 4.07709 11.5066 3.66669 11.0003 3.66669C10.4941 3.66669 10.0837 4.07709 10.0837 4.58335C10.0837 5.08961 10.4941 5.50002 11.0003 5.50002Z" stroke="#2D322F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M17.417 5.50002C17.9233 5.50002 18.3337 5.08961 18.3337 4.58335C18.3337 4.07709 17.9233 3.66669 17.417 3.66669C16.9107 3.66669 16.5003 4.07709 16.5003 4.58335C16.5003 5.08961 16.9107 5.50002 17.417 5.50002Z" stroke="#2D322F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M4.58366 11.9167C5.08992 11.9167 5.50033 11.5063 5.50033 11C5.50033 10.4938 5.08992 10.0834 4.58366 10.0834C4.0774 10.0834 3.66699 10.4938 3.66699 11C3.66699 11.5063 4.0774 11.9167 4.58366 11.9167Z" stroke="#2D322F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M11.0003 11.9167C11.5066 11.9167 11.917 11.5063 11.917 11C11.917 10.4938 11.5066 10.0834 11.0003 10.0834C10.4941 10.0834 10.0837 10.4938 10.0837 11C10.0837 11.5063 10.4941 11.9167 11.0003 11.9167Z" stroke="#2D322F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M17.417 11.9167C17.9233 11.9167 18.3337 11.5063 18.3337 11C18.3337 10.4938 17.9233 10.0834 17.417 10.0834C16.9107 10.0834 16.5003 10.4938 16.5003 11C16.5003 11.5063 16.9107 11.9167 17.417 11.9167Z" stroke="#2D322F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M4.58366 18.3334C5.08992 18.3334 5.50033 17.9229 5.50033 17.4167C5.50033 16.9104 5.08992 16.5 4.58366 16.5C4.0774 16.5 3.66699 16.9104 3.66699 17.4167C3.66699 17.9229 4.0774 18.3334 4.58366 18.3334Z" stroke="#2D322F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M11.0003 18.3334C11.5066 18.3334 11.917 17.9229 11.917 17.4167C11.917 16.9104 11.5066 16.5 11.0003 16.5C10.4941 16.5 10.0837 16.9104 10.0837 17.4167C10.0837 17.9229 10.4941 18.3334 11.0003 18.3334Z" stroke="#2D322F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M17.417 18.3334C17.9233 18.3334 18.3337 17.9229 18.3337 17.4167C18.3337 16.9104 17.9233 16.5 17.417 16.5C16.9107 16.5 16.5003 16.9104 16.5003 17.4167C16.5003 17.9229 16.9107 18.3334 17.417 18.3334Z" stroke="#2D322F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
							<span>Меню</span>
						</button>
						<?php

						$headerMenu = get_field('header-menu', 'options');
						echo '<nav class="menu__body" style="opacity: 0;">';
							echo '<ul>';
								foreach ($headerMenu as $item) :
									$link = $item['menu_link'];
									$icon = $item['menu_icon'];

									echo '<li>';
										echo '<a href="'. $link['url'] .'" target="'. $link['target'] .'">';
											echo '<i class="_icon-'. $icon .'"></i>';
											echo '<span>'. $link['title'] .'</span>';
										echo '</a>';
									echo '</li>';
								endforeach;
							echo '</ul>';
						echo '</nav>';
					echo '</div>';

					$contacts = get_field('contacts', 'options');
					$phone = $contacts['contacts_phone'];
					$phonePreg =  preg_replace("/[^0-9]/", '', $phone);
					$mail = $contacts['contacts_mail'];
					echo '<div class="header__contacts contacts">';
						echo '<div class="contacts__item contacts__item_phone"><a href="tel:+'. $phonePreg .'">'. $phone .'</a></div>';
						echo '<div class="contacts__item"><a href="mailto:'. $mail .'">'. $mail .'</a></div>';
					echo '</div>';
				echo '</div>';

				echo '<div class="header__center">';
					echo '<a href="'. get_home_url() .'" class="header__logo logo">';
						echo '<div class="logo__img">';
							include 'parts/logo.php';
						echo '</div>';
						echo '<div class="logo__text">Бани <br> бочки</div>';
					echo '</a>';
				echo '</div>';

				echo '<div class="header__right">';
					echo '<nav class="header__language language">';
						wp_nav_menu([
							'theme_location'  => 'lang',
							'container'       => false,
							'menu_class'      => "",
						]);
					echo '</nav>';
					echo '<button type="button" class="header__button _hover-green" data-popup="#request">';
						echo '<span>Заказать рассчёт</span>';
						echo '<i class="_icon-calculator"></i>';
					echo '</button>';
				echo '</div>';
			echo '</div>';
		echo '</header>';
	?>