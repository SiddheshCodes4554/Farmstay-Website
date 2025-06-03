// Navigation
const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');

    burger.addEventListener('click', () => {
        // Toggle Nav
        nav.classList.toggle('nav-active');

        // Animate Links
        navLinks.forEach((link, index) => {
            if (link.style.animation) {
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
            }
        });

        // Burger Animation
        burger.classList.toggle('toggle');
    });
}

navSlide();

// Smooth Scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Header Scroll Effect
const header = document.querySelector('header');
const headerScrollThreshold = 100;

window.addEventListener('scroll', () => {
    if (window.scrollY > headerScrollThreshold) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// GSAP Animations
gsap.registerPlugin(ScrollTrigger);

// Hero Section Animation
gsap.from('.hero-content', {
    opacity: 0,
    y: 50,
    duration: 1,
    delay: 0.5
});

gsap.from('.hero-scroll-indicator', {
    opacity: 0,
    y: -20,
    duration: 1,
    delay: 1.5
});

// Features Section Animation
gsap.from('.feature', {
    scrollTrigger: {
        trigger: '.features',
        start: 'top 80%',
    },
    opacity: 0,
    y: 50,
    stagger: 0.2,
    duration: 1
});

// About Section Animation
gsap.from('.about-content', {
    scrollTrigger: {
        trigger: '.about',
        start: 'top 80%',
    },
    opacity: 0,
    x: -50,
    duration: 1
});

gsap.from('.about-image', {
    scrollTrigger: {
        trigger: '.about',
        start: 'top 80%',
    },
    opacity: 0,
    x: 50,
    duration: 1
});

// Gallery Section Animation
gsap.from('.gallery-item', {
    scrollTrigger: {
        trigger: '.gallery',
        start: 'top 80%',
    },
    opacity: 0,
    scale: 0.8,
    stagger: 0.2,
    duration: 1
});

// Contact Form Animation
gsap.from('#booking-form', {
    scrollTrigger: {
        trigger: '.contact',
        start: 'top 80%',
    },
    opacity: 0,
    y: 50,
    duration: 1
});

// Image Lazy Loading
document.addEventListener('DOMContentLoaded', function() {
    var lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));

    if ('IntersectionObserver' in window) {
        let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;
                    lazyImage.src = lazyImage.dataset.src;
                    lazyImage.classList.remove('lazy');
                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function(lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    }
});

// Parallax Effect
window.addEventListener('scroll', () => {
    const parallaxElements = document.querySelectorAll('.parallax');
    parallaxElements.forEach(element => {
        const speed = element.dataset.speed;
        element.style.transform = `translateY(${window.pageYOffset * speed}px)`;
    });
});