// resources/js/home-swiper.js

import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

function initSwiper() {
    const container = document.querySelector('.product-swiper');
    if (container && !container.swiper) {
        new Swiper('.product-swiper', {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: { slidesPerView: 3, spaceBetween: 15 },
                1024: { slidesPerView: 4, spaceBetween: 20 },
                1280: { slidesPerView: 6, spaceBetween: 25 },
                1920: { slidesPerView: 8, spaceBetween: 25 },
            },
        });
    }
}

// بارگذاری اولیه
document.addEventListener('DOMContentLoaded', initSwiper);
// برای لایووایر و navigation
document.addEventListener('livewire:navigated', initSwiper);
