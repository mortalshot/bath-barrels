// Подключение функционала 
import { isMobile, menuClose, bodyLockStatus } from "./functions.js";
// Подключение списка активных модулей
import { flsModules } from "./modules.js";

document.addEventListener('click', function (e) {
   // Прячем меню, если кликаем вне области меню
   if (bodyLockStatus) {
      if (!e.target.closest('.header__menu') && !document.documentElement.classList.contains('popup-show')) {
         menuClose();
      }
   }
})

// Прячем меню на escape
document.onkeydown = function (evt) {
   evt = evt || window.event;
   // Если нажали ESC
   if (evt.keyCode == 27) {
      menuClose();
   }
};

// Прячем меню когда кликаем на ссылку в меню
const headerMenuLinks = document.querySelectorAll('.menu a');
if (headerMenuLinks.length > 0) {
   headerMenuLinks.forEach(element => {
      element.addEventListener('click', function () {
         menuClose();
      })
   });
}

// Добавляем пробел для больших чисел
function numberWithSpaces(x) {
   return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

const productOptions = document.querySelectorAll('.product-options__item');
// Сумма всех допов
let optionsTotalSum = 0;

if (productOptions.length > 0) {
   const productPrice = document.querySelector('.price-list__row_main .price-list__price span').innerHTML;
   const productSummary = document.querySelector('.product-sidebar__summary .title-h3 span');

   productOptions.forEach(item => {
      const optionsRow = item.querySelectorAll('.product-options__row');

      optionsRow.forEach(row => {
         const inputs = row.querySelectorAll('.product-options__input');
         let rowSum = 0;

         inputs.forEach(element => {
            const parent = element.closest('.product-options__item');
            const totalSpan = parent.querySelector('.product-options__total span');
            const optionsRow = parent.querySelector('.product-options__row');
            const priceListOptions = document.querySelector('.price-list__options');
            const priceListAdds = document.querySelector('.price-list__row_adds ul');

            // Выбираем опцию
            element.addEventListener('change', function () {
               const option = element.closest('.product-options__option');

               // Отслеживаем класс checked на radio кнопках
               const checkedItem = parent.querySelector('.checked');
               if (checkedItem) {
                  checkedItem.classList.remove('checked');
               }
               if (element.getAttribute('type') == 'radio') {
                  element.classList.add('checked');
               }

               // Если это радио баттоны
               if (optionsRow.classList.contains('product-options__row_radio')) {
                  totalSpan.innerHTML = option.dataset.price;
                  rowSum += Number(option.dataset.price);
               }

               // Если это чекбоксы
               if (optionsRow.classList.contains('product-options__row_checkbox')) {
                  if (this.checked) {
                     rowSum += Number(option.dataset.price);
                  } else {
                     rowSum -= Number(option.dataset.price);
                  }

                  totalSpan.innerHTML = rowSum;
               }

               // Обнуляем счетчик
               optionsTotalSum = 0;

               priceListOptions.innerHTML = "";
               priceListAdds.innerHTML = "";

               // Собираем суммы выбранных опций
               const totalCaptions = document.querySelectorAll('.product-options__total span');

               totalCaptions.forEach(rowTotal => {
                  optionsTotalSum += Number(rowTotal.innerHTML);
               });

               // Показываем сумму всех допов и стоимость продукта
               productSummary.innerHTML = numberWithSpaces(Number(productPrice.replace(/\s/g, '')) + optionsTotalSum);

               changeHiddenSummaryValue();
            })

            element.addEventListener('click', function () {
               // Отменяем checked на radio, если кликаем на выбранный инпут
               if (element.classList.contains('checked')) {
                  const option = element.closest('.product-options__option');
                  const title = parent.querySelector('.title-h4');
                  const priceListOptions = document.querySelectorAll('.price-list__options .price-list__row')

                  // Обнуляем счетчик
                  optionsTotalSum = 0;

                  // Собираем суммы выбранных опций
                  const totalCaptions = document.querySelectorAll('.product-options__total span');

                  totalCaptions.forEach(rowTotal => {
                     optionsTotalSum += Number(rowTotal.innerHTML);
                  });

                  element.classList.remove('checked');
                  element.checked = false;

                  productSummary.innerHTML = numberWithSpaces(Number(productPrice.replace(/\s/g, '')) + optionsTotalSum - option.dataset.price);
                  // Обнуляем сумму группы опций
                  totalSpan.innerHTML = 0;

                  // Удаляем текст опций из прайслиста
                  if (priceListOptions.length > 0) {
                     priceListOptions.forEach(row => {
                        const rowCaption = row.querySelector('.price-list__caption');

                        if (rowCaption.innerHTML == title.innerHTML) {
                           row.remove();
                        }
                     });
                  }

                  changeHiddenSummaryValue();
               }
            })
         });
      });
   });
}

// Выводим выбранные опции
// Добавляем в скрытый инпут выбранные опции и название товара
function changeHiddenSummaryValue() {
   // Скрытый инпут, в котором хранятся название товара и выбранные опции
   const hiddenSummary = document.querySelector('.product-summary');

   // Название продукта
   const productName = document.querySelector('.price-list__row_main .price-list__name');

   // Цена продукта
   const productPrice = document.querySelector('.price-list__row_main .price-list__price span').innerHTML;

   // Итоговая цена продукта с выбранными опциями
   const productSummary = document.querySelector('.product-sidebar__summary .title-h3 span');

   // Добавляем в скрытый инпут название товара и его стоимость
   hiddenSummary.value = `Наименование: ${productName.innerHTML} (${numberWithSpaces(productPrice)})` + `\r\n`;

   // div с выбранными опциями
   const priceListOptions = document.querySelector('.price-list__options');

   // в этот список выводятся дополнительные опции (чекбоксы)
   const priceListAdds = document.querySelector('.price-list__row_adds ul');

   const addsChecked = document.querySelectorAll('.product-options__input:checked');
   if (addsChecked.length > 0) {
      addsChecked.forEach(input => {
         const name = input.value;
         const parent = input.closest('.product-options__item');
         const title = parent.querySelector('.title-h4');
         const option = input.closest('.product-options__option');
         const price = option.dataset.price;

         // Добавляем в скрытый инпут выбранные опции
         hiddenSummary.value += title.innerHTML + ': ' + input.value + ` (${numberWithSpaces(price)})` + `\r\n`;

         if (!option.classList.contains('product-options__option_checkbox')) {
            priceListOptions.innerHTML += `
                                    <div class="price-list__row price-list__row_main">
                                       <div class="price-list__caption">${title.innerHTML}</div>
                                       <ul>
                                          <li>
                                             <div class="price-list__name">${name}</div>
                                             <div class="price-list__price"><span>${numberWithSpaces(price)}</span> ₽</div>
                                          </li>
                                       </ul>
                                    </div>
                                 `;
         } else {
            document.querySelector('.price-list__row_adds').classList.add('_active');
            priceListAdds.innerHTML += `
                                    <li>
                                       <div class="price-list__name">${name}</div>
                                       <div class="price-list__price"><span>${numberWithSpaces(price)}</span> ₽</div>
                                    </li>
                                 `;
         }
      });
   }

   hiddenSummary.value += `Итого: ${productSummary.innerHTML}`;
}

// Показываем кнопку "Заказать" на мобильных устройствах
if (window.innerWidth <= 767.98) {
   const toSidebar = document.querySelector('.to-sidebar');
   const productSidebar = document.querySelector('.product-sidebar');
   const footer = document.querySelector('.footer');
   console.log(footer.offsetTop);

   if (toSidebar) {
      document.addEventListener("windowScroll", function (e) {
         const scrollTop = window.scrollY;

         if (scrollTop > productSidebar.offsetTop + productSidebar.offsetHeight && scrollTop + window.innerHeight - 20 < footer.offsetTop) {
            toSidebar.classList.add('_active');
         }
         else {
            toSidebar.classList.remove('_active');
         }
      })
   }
}

// Обработка селекта
let sorting = "ASC";
let taxonomy = "";
document.addEventListener("selectCallback", function (e) {
   const currentSelect = e.detail.select;
   if (currentSelect.classList.contains('sorting')) {
      sorting = currentSelect.value;

      postFiltering(taxonomy, sorting);
   }
});

// Ajax фильтр по таксономии
const catalogFilters = document.querySelectorAll('.catalog-filter__item .checkbox__input');
if (catalogFilters.length > 0) {
   catalogFilters.forEach(filter => {
      filter.addEventListener('change', function () {
         const parent = this.closest('.catalog-filter__item');
         taxonomy = parent.dataset.category;

         postFiltering(taxonomy, sorting);
      })
   });
}

function postFiltering(taxonomy, sorting) {
   fetch(ajax_object.ajaxurl, {
      method: "POST",
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=getpost&post_type=products&page=1&taxonomy=${taxonomy}&order=${sorting}`
   }).then(
      res => res.text(),
   ).then(
      data => {
         document.querySelector('.main-catalog__articles').innerHTML = data;
         outputProductNameOnModalOpen();
      }
   ).catch(error => {
      alert('Ошибка');
      // output.classList.remove('_loading');
   })
}

// Передаем способ связи для модального окна request
const communicationType = document.querySelector('.communication__type');
if (communicationType) {
   // Добавляем значение по умолчанию
   communicationType.value = "Telegram";

   // Передаем выбранное значение
   const communicationItems = document.querySelectorAll('.communication__input');
   communicationItems.forEach(input => {
      input.addEventListener('change', function () {
         communicationType.value = this.value;
      })
   });
}

// Выводим в скрытый инпут название продукта, который заинтересовал клиента
const hiddenProductInput = document.querySelector('.product-name');

function outputProductNameOnModalOpen() {
   const products = document.querySelectorAll('.main-product');

   if (products.length > 0) {
      products.forEach(product => {
         const productName = product.querySelector('.main-product__title').innerHTML;
         const button = product.querySelector('.main-product__button button');

         button.addEventListener('click', function () {
            hiddenProductInput.value = `Название продукта: ${productName}`;
         })
      });
   }
}
outputProductNameOnModalOpen();

document.addEventListener("afterPopupClose", function (e) {
   // Очищаем скрытый инпут с названием продукта после закрытия попапа
   hiddenProductInput.value = "";
});