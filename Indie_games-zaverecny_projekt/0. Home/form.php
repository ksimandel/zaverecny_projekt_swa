<?php
// Initialize message variables
$status_msg = "";
$status_type = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Enter YOUR email address where you want to receive messages
    $to_email = "your-email@example.com"; 
    
    // 2. Collect and sanitize form inputs to prevent exploits
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));
    
    // Simple validation check
    if (empty($name) || empty($email) || empty($message)) {
        $status_msg = "Please fill in all fields.";
        $status_type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $status_msg = "Invalid email format.";
        $status_type = "error";
    } else {
        // 3. Set up the email header details
        $subject = "New Contact Form Message from: $name";
        
        $email_content = "You have received a new message from your website contact form.\n\n";
        $email_content .= "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";
        
        // Headers to ensure proper delivery and reply routing
        $headers = "From: webmaster@indieler.com\r\n"; // Often needs to match your domain
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        // 4. Send the email using PHP's native mail function
        if (mail($to_email, $subject, $email_content, $headers)) {
            $status_msg = "Thank you! Your message has been sent successfully.";
            $status_type = "success";
        } else {
            $status_msg = "Oops! Something went wrong, and we couldn't send your message.";
            $status_type = "error";
        }
    }
}
?>

<!-- CONTACT US SECTION -->
<section id="kontakt" class="contact-section">
  <div class="contact-container">
    <h2>Contact Us</h2>
    <p>Have a question or feedback about Indieler? Drop us a message below!</p>
    
    <!-- Dynamic Alert System -->
    <?php if (!empty($status_msg)): ?>
        <div class="form-alert <?php echo $status_type; ?>">
            <?php echo $status_msg; ?>
        </div>
    <?php endif; ?>
    
    <!-- Action points to the exact same file to process data cleanly -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#kontakt" method="POST" class="contact-form">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your Name" required>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
      </div>

      <div class="form-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" placeholder="Type your message here..." required></textarea>
      </div>

      <button type="submit" class="submit-button">Send Message</button>
    </form>
  </div>
</section>