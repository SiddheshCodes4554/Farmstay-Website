<?php
// Database connection details
require_once 'admin/config.php';

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    // Retrieve and sanitize form data
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $message = sanitize_input($_POST['message']);

    // Validate input
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($message)) {
        $errors[] = "Message is required";
    }

    // If there are no errors, proceed with database insertion
    if (empty($errors)) {
        try {
            // Prepare SQL statement
            $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, message) VALUES (:name, :email, :message)");

            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':message', $message);

            // Execute the statement
            $stmt->execute();

            // Send a success response
            echo json_encode(['success' => true, 'message' => 'Thank you for your message! We will get back to you soon.']);
            exit;
        } catch(PDOException $e) {
            // Log the error
            error_log("Database Error: " . $e->getMessage());
            
            // Send an error response
            echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
            exit;
        }
    } else {
        // Send an error response with validation errors
        echo json_encode(['success' => false, 'message' => 'Please correct the following errors:', 'errors' => $errors]);
        exit;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Stays</title>
    <link rel="stylesheet" href="styles/stylesnew.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img style="height: 100px;width: 100px;" src="constants/Logo.png" alt="Farmstay Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
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
        <section id="home" class="hero">
            <div class="hero-content">
                <h1>Welcome to Our Stay</h1>
                <p>Experience nature's tranquility</p>
                <a href="#contact" class="cta-button">Book Now</a>
            </div>
            <div class="hero-scroll-indicator">
                <span>Scroll</span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </section>

        <section id="features" class="features">
            <h2>Special Features</h2>
            <div class="feature-grid">
                <div class="feature">
                    <i class="fas fa-tree"></i>
                    <h3>Scenic Views</h3>
                    <p>Breathtaking riverside landscapes</p>
                </div>
                <div class="feature">
                    <i class="fas fa-home"></i>
                    <h3>Cozy Accommodations</h3>
                    <p>Comfortable and rustic farmhouse living</p>
                </div>
                <div class="feature">
                    <i class="fas fa-utensils"></i>
                    <h3>Farm-to-Table Dining</h3>
                    <p>Fresh, locally sourced ingredients</p>
                </div>
            </div>
        </section>

        <section id="about" class="about">
            <div class="about-content">
                <h2>About Our Farmstay</h2>
                <p>Nestled along the picturesque riverside, our farmstay offers a perfect blend of rustic charm and modern comfort. Immerse yourself in nature, enjoy farm-fresh meals, and create unforgettable memories.</p>
                <ul class="about-highlights">
                    <li><i class="fas fa-check"></i> Sustainable farming practices</li>
                    <li><i class="fas fa-check"></i> Family-friendly activities</li>
                    <li><i class="fas fa-check"></i> Pet-friendly accommodations</li>
                </ul>
            </div>
            <div class="about-image">
                <img src="https://images.pexels.com/photos/2893177/pexels-photo-2893177.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Riverside Farmstay">
            </div>
        </section>

        <section id="gallery" class="gallery">
            <h2>Gallery</h2>
            <div class="image-grid">
                <div class="gallery-item">
                    <img src="https://images.pexels.com/photos/1007328/pexels-photo-1007328.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Farmstay Gallery 1">
                    <div class="gallery-overlay">
                        <span>Cozy Cabins</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="https://images.pexels.com/photos/28971472/pexels-photo-28971472/free-photo-of-scenic-countryside-farmhouse-and-barn.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Farmstay Gallery 2">
                    <div class="gallery-overlay">
                        <span>Riverside Views</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="location" class="location">
            <h2>Our Location</h2>
            <div id="map"><iframe style="height: 400px;width: 100%;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d23254.967321947977!2d73.98397947239677!3d15.968116970565047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc077a18e5891ab%3A0x37b84c05e0a2123f!2sAmboli%2C%20Maharashtra%20416510!5e1!3m2!1sen!2sin!4v1729346308968!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
            <div class="location-info">
                <h3>How to Reach Us</h3>
                <p><i class="fas fa-map-marker-alt"></i> 123 Riverside Lane, Farmville, Country</p>
                <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                <p><i class="fas fa-envelope"></i> info@riversidefarmstay.com</p>
            </div>
        </section>

        <section id="contact" class="contact">
            <h2>Book Your Stay</h2>
            <form id="booking-form" action="index.php" method="POST">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <textarea name="message" placeholder="Your Enquiries" rows="4"></textarea>
                <button type="submit" name="submit">Contact Now</button>
            </form>
            <div id="form-response" class="hidden"></div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-info">
                <h3>Riverside Farmstay</h3>
                <p>Your perfect getaway in nature's lap</p>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#gallery">Gallery</a></li>
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
            <p>&copy; 2023 Riverside Farmstay. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts/scriptnew.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
    <script>
        $(document).ready(function() {
            $('#booking-form').submit(function(e) {
                e.preventDefault();
                
                // Clear any existing messages
                $('#form-response').html('').removeClass('hidden');
                
                // Show loading state
                const submitButton = $(this).find('button[type="submit"]');
                const originalText = submitButton.text();
                submitButton.prop('disabled', true).text('Sending...');
                
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message with green background
                            $('#form-response').html(`
                                <div style="background-color: #dff0d8; color: #3c763d; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                                    <i class="fas fa-check-circle"></i> ${response.message}
                                </div>
                            `);
                            // Clear the form
                            $('#booking-form')[0].reset();
                            
                            // Hide the success message after 5 seconds
                            setTimeout(function() {
                                $('#form-response').fadeOut('slow', function() {
                                    $(this).html('').addClass('hidden').show();
                                });
                            }, 5000);
                        } else {
                            // Show error message with red background
                            let errorMessage = `
                                <div style="background-color: #f2dede; color: #a94442; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                                    <i class="fas fa-exclamation-circle"></i> ${response.message}
                                `;
                            if (response.errors) {
                                errorMessage += '<ul style="margin-top: 10px; margin-bottom: 0;">';
                                response.errors.forEach(function(error) {
                                    errorMessage += `<li>${error}</li>`;
                                });
                                errorMessage += '</ul>';
                            }
                            errorMessage += '</div>';
                            $('#form-response').html(errorMessage);
                        }
                    },
                    error: function() {
                        $('#form-response').html(`
                            <div style="background-color: #f2dede; color: #a94442; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                                <i class="fas fa-exclamation-circle"></i> An error occurred. Please try again later.
                            </div>
                        `);
                    },
                    complete: function() {
                        // Restore button state
                        submitButton.prop('disabled', false).text(originalText);
                    }
                });
            });
        });
    </script>
</body>
</html>