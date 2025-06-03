// GSAP Animations
gsap.registerPlugin(ScrollTrigger);

// Gallery Hero Section Animation
gsap.from('.gallery-hero-content', {
    opacity: 0,
    y: 50,
    duration: 1,
    delay: 0.5
});

// Filter Buttons Animation
gsap.from('.filter-btn', {
    scrollTrigger: {
        trigger: '.gallery-filters',
        start: 'top 80%',
    },
    opacity: 0,
    y: 20,
    stagger: 0.1,
    duration: 0.5
});

// Gallery Grid Animation
gsap.from('.gallery-item', {
    scrollTrigger: {
        trigger: '.gallery-grid',
        start: 'top 80%',
    },
    opacity: 0,
    y: 50,
    stagger: 0.1,
    duration: 0.5
});

// Masonry Layout
var grid = document.querySelector('.gallery-grid .container');
var masonry;

imagesLoaded(grid, function() {
    masonry = new Masonry(grid, {
        itemSelector: '.gallery-item',
        columnWidth: '.grid-sizer',
        percentPosition: true
    });
});

// Filtering
const filterButtons = document.querySelectorAll('.filter-btn');
const galleryItems = document.querySelectorAll('.gallery-item');

filterButtons.forEach(button => {
    button.addEventListener('click', () => {
        const filter = button.getAttribute('data-filter');
        
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        galleryItems.forEach(item => {
            if (filter === 'all' || item.classList.contains(filter)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });

        masonry.layout();
    });
});

// Lightbox
const lightbox = document.querySelector('.lightbox');
const lightboxImage = document.querySelector('.lightbox-image');
const lightboxCaption = document.querySelector('.lightbox-caption');
const closeLightbox = document.querySelector('.close-lightbox');

galleryItems.forEach(item => {
    item.addEventListener('click', () => {
        const imgSrc = item.querySelector('img').getAttribute('src');
        const imgAlt = item.querySelector('img').getAttribute('alt');
        
        lightboxImage.setAttribute('src', imgSrc);
        lightboxCaption.textContent = imgAlt;
        lightbox.style.display = 'flex';
    });
});

closeLightbox.addEventListener('click', () => {
    lightbox.style.display = 'none';
});

lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) {
        lightbox.style.display = 'none';
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