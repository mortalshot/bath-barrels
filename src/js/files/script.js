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