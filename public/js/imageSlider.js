const slides = document.querySelector('.slides');
const slideImages = document.querySelectorAll('.slides img');

let counter = 0;
const size = slideImages[0].clientWidth;

function slide() {
    if (counter >= slideImages.length - 1) {
        counter = -1;
    }
    counter++;
    slides.style.transform = 'translateX(' + (-size * counter) + 'px)';
}

setInterval(slide, 5000); 
