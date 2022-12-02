/*
Документация по работе в шаблоне: 
Документация слайдера: https://swiperjs.com/
Сниппет(HTML): swiper
*/

// Подключаем слайдер Swiper из node_modules
// При необходимости подключаем дополнительные модули слайдера, указывая их в {} через запятую
// Пример: { Navigation, Autoplay }
import Swiper, { Navigation, Pagination } from 'swiper';
/*
Основниые модули слайдера:
Navigation, Pagination, Autoplay, 
EffectFade, Lazy, Manipulation
Подробнее смотри https://swiperjs.com/
*/

// Стили Swiper
// Базовые стили
import "../../scss/base/swiper.scss";
// Полный набор стилей из scss/libs/swiper.scss
// import "../../scss/libs/swiper.scss";
// Полный набор стилей из node_modules
// import 'swiper/css';

// Инициализация слайдеров
function initSliders() {
	if (document.querySelector('.manufacturers__slider')) {
		new Swiper('.manufacturers__slider', {
			modules: [Navigation, Pagination],
			observer: true,
			observeParents: true,
			slidesPerView: 2,
			spaceBetween: 10,
			speed: 800,

			//touchRatio: 0,
			//simulateTouch: false,
			// loop: true,

			// Пагинация
			pagination: {
				el: '.manufacturers__slider .swiper-pagination',
				clickable: true,
			},


			// Скроллбар
			/*
			scrollbar: {
				el: '.swiper-scrollbar',
				draggable: true,
			},
			*/

			// Кнопки "влево/вправо"
			navigation: {
				prevEl: '.manufacturers .swiper__arrow_left',
				nextEl: '.manufacturers .swiper__arrow_right',
			},

			// Брейкпоинты
			/*
			breakpoints: {
				320: {
					slidesPerView: 1,
					spaceBetween: 0,
					autoHeight: true,
				},
			},
			*/
			// События
			on: {
			}
		});
	}

	if (document.querySelector('.cases__slider')) {
		new Swiper('.cases__slider', {
			modules: [Navigation, Pagination],
			observer: true,
			observeParents: true,
			slidesPerView: 1,
			spaceBetween: 10,
			speed: 800,


			//touchRatio: 0,
			//simulateTouch: false,
			// loop: true,

			// Пагинация
			/* pagination: {
				el: '.manufacturers__slider .swiper-pagination',
				clickable: true,
			}, */


			// Скроллбар
			/*
			scrollbar: {
				el: '.swiper-scrollbar',
				draggable: true,
			},
			*/

			// Кнопки "влево/вправо"
			navigation: {
				prevEl: '.cases .swiper__arrow_left',
				nextEl: '.cases .swiper__arrow_right',
			},

			// Брейкпоинты
			/*
			breakpoints: {
				320: {
					slidesPerView: 1,
					spaceBetween: 0,
					autoHeight: true,
				},
			},
			*/
			// События
			on: {
			}
		});
	}

	if (document.querySelector('.case__gallery')) {
		let caseGalleryMd3 = window.matchMedia('(max-width: 767.98px)');
		var init = false;
		let caseGallery;

		function clientsHandleMd2Change(e) {
			if (e.matches) {
				if (!init) {
					init = true;
					caseGallery = new Swiper('.case__gallery', {
						modules: [Pagination],
						observer: true,
						observeParents: true,
						slidesPerView: 1,
						spaceBetween: 10,
						speed: 800,


						//touchRatio: 0,
						//simulateTouch: false,
						// loop: true,

						// Пагинация
						pagination: {
							el: '.case__gallery .swiper-pagination',
							clickable: true,
						},


						// Скроллбар
						/*
						scrollbar: {
							el: '.swiper-scrollbar',
							draggable: true,
						},
						*/

						// Кнопки "влево/вправо"
						/* navigation: {
							prevEl: '.cases .swiper__arrow_left',
							nextEl: '.cases .swiper__arrow_right',
						}, */

						// Брейкпоинты

						breakpoints: {
							480: {
								slidesPerView: 2,
								spaceBetween: 8,
							},
						},

						// События
						on: {
						}
					});
				}
			} else if (init) {
				caseGallery.destroy();
				init = false;
			}
		}
		caseGalleryMd3.addEventListener('change', clientsHandleMd2Change);
		clientsHandleMd2Change(caseGalleryMd3);

	}
}
// Скролл на базе слайдера (по классу swiper_scroll для оболочки слайдера)
function initSlidersScroll() {
	let sliderScrollItems = document.querySelectorAll('.swiper_scroll');
	if (sliderScrollItems.length > 0) {
		for (let index = 0; index < sliderScrollItems.length; index++) {
			const sliderScrollItem = sliderScrollItems[index];
			const sliderScrollBar = sliderScrollItem.querySelector('.swiper-scrollbar');
			const sliderScroll = new Swiper(sliderScrollItem, {
				observer: true,
				observeParents: true,
				direction: 'vertical',
				slidesPerView: 'auto',
				freeMode: {
					enabled: true,
				},
				scrollbar: {
					el: sliderScrollBar,
					draggable: true,
					snapOnRelease: false
				},
				mousewheel: {
					releaseOnEdges: true,
				},
			});
			sliderScroll.scrollbar.updateSize();
		}
	}
}

window.addEventListener("load", function (e) {
	// Запуск инициализации слайдеров
	initSliders();
	// Запуск инициализации скролла на базе слайдера (по классу swiper_scroll)
	//initSlidersScroll();
});