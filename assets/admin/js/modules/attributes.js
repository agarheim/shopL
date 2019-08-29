'use strict'
window.addEventListener('load', () => {
    let container, amountElement;

    container = document.getElementsByClassName('js-update-amount').item(0).closest('.sonata-ba-field-inline-table');
    amountElement = document.querySelector('.js-amount');
    if (container) {
        container.addEventListener('input', (event) => {
            if (event.target.classList.contains('js-update-amount')) {
             //   updateAmount();
            }
        });
        $(container).on('change', (event) => {
            if (event.target.name.indexOf('[product]') > 0) {
               // updatePrice(event.target);
            }
        });
    }

});