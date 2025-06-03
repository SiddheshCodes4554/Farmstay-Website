<?php
 
include_once("admin/config.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Wete's Riverside Farmstay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

:root {
    --primary-color: #4a6741;
    --secondary-color: #f0e6d2;
    --accent-color: #e9b44c;
    --text-color: #333;
    --background-color: #fff;
    --transition-speed: 0.3s;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    background-color: var(--background-color);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header styles */
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    background-color: rgba(255, 255, 255, 0.9);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 5%;
}

.logo img {
    height: 70px;
    transition: transform var(--transition-speed) ease;
}

.logo img:hover {
    transform: scale(1.05);
}

.nav-links {
    display: flex;
    list-style: none;
}

.nav-links li {
    margin-left: 2rem;
}

.nav-links a {
    text-decoration: none;
    color: var(--text-color);
    font-weight: 600;
    transition: color var(--transition-speed) ease;
    position: relative;
}

.nav-links a::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 2px;
    bottom: -5px;
    left: 0;
    background-color: var(--primary-color);
    transform: scaleX(0);
    transition: transform var(--transition-speed) ease;
}

.nav-links a:hover::after {
    transform: scaleX(1);
}

.burger {
    display: none;
    cursor: pointer;
}

.burger div {
    width: 25px;
    height: 3px;
    background-color: var(--text-color);
    margin: 5px;
    transition: all var(--transition-speed) ease;
}

/* Hero Section */
.hero {
    height: 60vh;
    background-image: url('https://images.pexels.com/photos/2893177/pexels-photo-2893177.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
}

.hero-content {
    position: relative;
    z-index: 1;
    color: #fff;
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.hero p {
    font-size: 1.5rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

/* Animated text */
.animate-text {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 1s ease forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Gallery Section */
.gallery {
    padding: 5rem 0;
    background-color: var(--secondary-color);
}

.gallery-filters {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

.filter-btn {
    background-color: var(--background-color);
    color: var(--text-color);
    border: none;
    padding: 0.5rem 1rem;
    margin: 0 0.5rem;
    cursor: pointer;
    transition: all var(--transition-speed) ease;
    border-radius: 20px;
}

.filter-btn:hover,
.filter-btn.active {
    background-color: var(--primary-color);
    color: var(--background-color);
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform var(--transition-speed) ease;
    cursor: pointer;
}

.gallery-item:hover {
    transform: translateY(-10px);
}

.gallery-item img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform var(--transition-speed) ease;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-item-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(74, 103, 65, 0.8);
    color: #fff;
    padding: 1rem;
    transform: translateY(100%);
    transition: transform var(--transition-speed) ease;
}

.gallery-item:hover .gallery-item-caption {
    transform: translateY(0);
}

.gallery-item-caption h3 {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
}

.gallery-item-caption p {
    font-size: 0.9rem;
}

/* Lightbox styles */
.lightbox  {
    display: none;
    position: fixed;
    z-index: 1001;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
}

.lightbox-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    max-height: 80%;
    object-fit: contain;
}

#lightbox-caption {
    margin: auto;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* Footer styles */
footer {
    background-color: var(--primary-color);
    color: #fff;
    padding: 3rem 10% 1rem;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-info h3 {
    margin-bottom: 1rem;
}

.footer-links h4,
.footer-social h4 {
    margin-bottom: 1rem;
}

.footer-links ul {
    list-style: none;
}

.footer-links a {
    color: #fff;
    text-decoration: none;
    transition: color var(--transition-speed) ease;
}

.footer-links a:hover {
    color: var(--accent-color);
}

.social-icons a {
    color: #fff;
    font-size: 1.5rem;
    margin-right: 1rem;
    transition: color var(--transition-speed) ease;
}

.social-icons a:hover {
    color: var(--accent-color);
}

.footer-bottom {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .nav-links {
        position: absolute;
        right: 0;
        height: 92vh;
        top: 8vh;
        background-color: rgba(255, 255, 255, 0.95);
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 50%;
        transform: translateX(100%);
        transition: transform 0.5s ease-in;
    }

    .nav-links li {
        opacity: 0;
    }

    .burger {
        display: block;
    }

    .gallery-filters {
        flex-wrap: wrap;
    }

    .filter-btn {
        margin: 0.5rem;
    }

    .lightbox-content {
        width: 100%;
    }

    #lightbox-caption {
        width: 100%;
    }
}

.nav-active {
    transform: translateX(0%);
}

@keyframes navLinkFade {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.toggle .line1 {
    transform: rotate(-45deg) translate(-5px, 6px);
}

.toggle .line2 {
    opacity: 0;
}

.toggle .line3 {
    transform: rotate(45deg) translate(-5px, -6px);
}
</style>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="constants/Logo.png" alt="Riverside Farmstay Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="gallery.php">Gallery</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1 class="animate-text">Our Gallery</h1>
                <p class="animate-text">Explore the beauty of Wete's Riverside Farmstay</p>
            </div>
        </section>

        <section class="gallery">
            <div class="container">
                <div class="gallery-grid">
<?php

	include "admin/config.php";

    $stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY uploaded_at DESC");
    $gallery_images = $stmt->fetchAll();

foreach ($gallery_images as $image): ?>
                    <div class="gallery-item">
                    <img src="uploads/<?php echo htmlspecialchars($image['filename']); ?>" alt="<?php echo htmlspecialchars($image['title']); ?>" class="w-full h-32 object-cover rounded-md">                      
                    </div>
    <?php endforeach; ?>                
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-info">
                <h3>Wete's Riverside Farmstay</h3>
                <p>Your perfect getaway in nature's lap</p>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                </ul>
            </div>
            <div class="footer-social">
                <h4>Connect With Us</h4>
                <div class="social-icons">
                    <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 Wete's Riverside Farmstay. All rights reserved.</p>
        </div>
    </footer>

    <div id="lightbox" class="lightbox">
        <span class="close">&times;</span>
        <img class="lightbox-content" id="lightbox-img">
        <div id="lightbox-caption"></div>
    </div>

<script>
   document.addEventListener('DOMContentLoaded', () => {
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

    // Gallery filtering
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            button.classList.add('active');

            const filter = button.getAttribute('data-filter');

            galleryItems.forEach(item => {
                if (filter === 'all' || item.classList.contains(filter)) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 500);
                }
            });
        });
    });

    // Parallax effect for hero section
    const hero = document.querySelector('.hero');
    window.addEventListener('scroll', () => {
        const scrollPosition = window.pageYOffset;
        hero.style.backgroundPositionY = `${scrollPosition * 0.7}px`;
    });

    // Animate gallery items on scroll
    const animateGalleryItems = () => {
        const triggerBottom = window.innerHeight / 5 * 4;

        galleryItems.forEach(item => {
            const itemTop = item.getBoundingClientRect().top;

            if (itemTop < triggerBottom) {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            } else {
                item.style.opacity = '0';
                item.style.transform = 'translateY(50px)';
            }
        });
    }

    window.addEventListener('scroll', animateGalleryItems);
    animateGalleryItems(); // Initial check on page load

    // Lightbox functionality
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const closeLightbox = document.querySelector('.close');

    galleryItems.forEach(item => {
        item.addEventListener('click', () => {
            lightbox.style.display = 'block';
            lightboxImg.src = item.querySelector('img').src;
            lightboxCaption.innerHTML = item.querySelector('.gallery-item-caption').innerHTML;
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

    // Keyboard navigation for lightbox
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox.style.display === 'block') {
            lightbox.style.display = 'none';
        }
    });
});
</script>
</body>
</html>