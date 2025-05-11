function learnMore() {
    const banner = document.querySelector('.banner');
    banner.classList.add('highlight');
    setTimeout(() => banner.classList.remove('highlight'), 1000);
}

let slideIndex = 0;

function showSlides() {
    const slides = document.querySelectorAll('.carousel-slide img');
    const dots = document.querySelectorAll('.dot');

    slides.forEach((slide, index) => {
        slide.style.display = 'none'; // Hide all images
        dots[index].className = dots[index].className.replace(' active', ''); // Reset active class
    });

    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }

    slides[slideIndex - 1].style.display = 'block'; // Show the next image
    dots[slideIndex - 1].className += ' active'; // Set the active class to the current dot
    setTimeout(showSlides, 3000); // Change image every 3 seconds
}

document.addEventListener('DOMContentLoaded', showSlides);

function nextSlide() {
    slideIndex++;
    showSlideManually();
}

function prevSlide() {
    slideIndex--;
    showSlideManually();
}

function showSlideManually() {
    const slides = document.querySelectorAll('.carousel-slide img');
    const dots = document.querySelectorAll('.dot');

    if (slideIndex > slides.length) { slideIndex = 1 }
    if (slideIndex < 1) { slideIndex = slides.length }

    slides.forEach((slide) => {
        slide.style.display = 'none';
    });

    dots.forEach((dot) => {
        dot.className = dot.className.replace(' active', ''); // Reset all dots
    });

    slides[slideIndex - 1].style.display = 'block'; // Show the current slide
    dots[slideIndex - 1].className += ' active'; // Set the active dot
}

// Reset the timer for auto-slide when manually navigating
function currentSlide(n) {
    slideIndex = n; // Set slideIndex to the clicked indicator
    showSlideManually();
}
