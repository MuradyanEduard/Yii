let show_cart = document.querySelector('.show_cart');
let basket = document.querySelector('.products_basket_window');
show_cart.addEventListener('click', function (){
   basket.style.display = 'block';
});

let hide_cart = document.querySelector('.hide_cart');
hide_cart.addEventListener('click', function (){
   basket.style.display = 'none';
});