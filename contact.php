<?php
// PHP BACK-END LOGIC
$message_sent = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $name = strip_tags(trim($_POST["name"]));
    $sender_email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject_line = strip_tags(trim($_POST["subject"]));
    $message_content = htmlspecialchars(trim($_POST["message"]));

    // Configuration
    $recipient = "orsonozie@gmail.com";
    $email_subject = "New AHI Website Inquiry: " . $subject_line;
    
    // Email Content
    $email_body = "You have received a new message from the AHI Website contact form.\n\n";
    $email_body .= "Full Name: $name\n";
    $email_body .= "Email: $sender_email\n\n";
    $email_body .= "Message:\n$message_content\n";

    // Email Headers
    $headers = "From: $name <$sender_email>\r\n";
    $headers .= "Reply-To: $sender_email\r\n";

    // Send Email
    if (mail($recipient, $email_subject, $email_body, $headers)) {
        $message_sent = true;
    } else {
        $error_message = "Oops! Something went wrong and we couldn't send your message.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | African Health Initiative</title>
    <link rel="icon" type="image/png" href="https://i.ibb.co/XfN6XqP/1000743306.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary-green: #054403; --white: #ffffff; --light-gray: #f4f4f4; --accent: #ff9900; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        
        nav { background: var(--primary-green); padding: 1rem 5%; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1000; }
        .logo-container { display: flex; align-items: center; color: white; text-decoration: none; }
        .logo-container img { height: 55px; border-radius: 50%; margin-right: 12px; border: 2px solid white; }
        
        .nav-links { display: flex; list-style: none; }
        .nav-links li { margin-left: 25px; }
        .nav-links a { color: white; text-decoration: none; font-weight: 500; transition: 0.3s; }
        .menu-toggle { display: none; color: white; font-size: 1.5rem; cursor: pointer; }

        .contact-container { padding: 60px 10%; display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 50px; }
        .info-card { background: var(--light-gray); padding: 25px; border-radius: 12px; border-left: 6px solid var(--primary-green); margin-bottom: 20px; }
        
        .form-card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-top: 5px solid var(--primary-green); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--primary-green); }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; }
        
        .submit-btn { background: var(--primary-green); color: white; border: none; padding: 15px; border-radius: 8px; width: 100%; cursor: pointer; font-weight: bold; font-size: 1.1rem; }
        
        /* Success/Error Alerts */
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        footer { background: #111; color: white; padding: 40px 10%; text-align: center; }

        @media (max-width: 768px) {
            .nav-links { display: none; flex-direction: column; position: absolute; top: 75px; left: 0; width: 100%; background: var(--primary-green); padding: 30px 0; }
            .nav-links.active { display: flex; }
            .nav-links li { margin: 15px 0; }
            .menu-toggle { display: block; }
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php" class="logo-container">
        <img src="https://i.ibb.co/XfN6XqP/1000743306.jpg" alt="AHI Logo">
        <div class="logo-text">
            <h1 style="font-size: 1.4rem;">AHI</h1>
            <span style="font-size: 0.8rem; color: var(--accent);">Quality Health for All</span>
        </div>
    </a>
    <ul class="nav-links" id="navLinks">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="contact.php">Contact Us</a></li>
    </ul>
    <div class="menu-toggle" onclick="toggleMenu()"><i class="fas fa-bars"></i></div>
</nav>

<div class="contact-container">
    <div class="contact-info">
        <h2 style="color: var(--primary-green); margin-bottom: 20px;">Connect With Us</h2>
        <div class="info-card">
            <h4><i class="fas fa-map-marker-alt"></i> Headquarters</h4>
            <p>St. [span_0](start_span)Andrew's Medical Centre, Masajja[span_0](end_span)</p>
        </div>
        <div class="info-card">
            <h4><i class="fas fa-id-card"></i> Membership</h4>
            [span_1](start_span)<p>Registration Fee: <strong>UGX 200,000</strong>[span_1](end_span)</p>
        </div>
    </div>

    <div class="form-card">
        <?php if($message_sent): ?>
            <div class="alert alert-success">Thank you! Your message has been sent to our team.</div>
        <?php elseif($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="yourname@gmail.com" required>
            </div>
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" placeholder="e.g., Membership Inquiry" required>
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" rows="5" placeholder="How can we help you?" required></textarea>
            </div>
            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</div>

<footer>
    <img src="https://i.ibb.co/XfN6XqP/1000743306.jpg" alt="AHI Logo" style="height: 60px; border-radius: 50%; margin-bottom: 15px;">
    <p>&copy; 2025 African Health Initiative (AHI). [span_2](start_span)All Rights Reserved.[span_2](end_span)</p>
</footer>

<script>
    function toggleMenu() {
        document.getElementById('navLinks').classList.toggle('active');
    }
</script>
</body>
</html>
