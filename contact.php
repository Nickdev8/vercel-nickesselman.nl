<?php
// =========================
// 1) Process form submission
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_reporting(-1);
    ini_set('display_errors', 'On');
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        echo "PHP Error [$errno]: $errstr in $errfile on line $errline";
    });
    
    // a) Sanitize inputs
    $name = trim(htmlspecialchars($_POST['name'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $message = trim(htmlspecialchars($_POST['message'] ?? ''));

    // b) Validate inputs
    $errors = [];
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (empty($message)) {
        $errors[] = 'Message cannot be empty.';
    }

    // c) If no errors, send email
    if (empty($errors)) {
        // Destination address (replace with your real email)
        $to = 'info@nickesselman.nl';
        $subject = 'Contact Form Submission from ' . $name;

        // Build plain-text email body
        $email_body = "Name: {$name}\r\n";
        $email_body .= "Email: {$email}\r\n\r\n";
        $email_body .= "Message:\r\n{$message}\r\n";

        // Basic headers: From and Reply-To
        $headers = "From: {$name} <{$email}>\r\n";
        $headers .= "Reply-To: {$email}\r\n";
        // (Optional) MIME headers if you want HTML instead of plain text
        // $headers .= "MIME-Version: 1.0\r\n";
        // $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send email
        if (mail($to, $subject, $email_body, $headers)) {
            $success_message = 'Thank you! Your message has been sent.';
        } else {
            $errors[] = 'Sorry—there was an error sending your message. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Me</title>
    <!-- Inline CSS for basic styling; you may move this into styles.css -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 0;
        }

        .contact-form {
            background: #fff;
            padding: 20px 24px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .contact-form h2 {
            margin-bottom: 16px;
            font-size: 1.4rem;
            text-align: center;
        }

        .contact-form label {
            display: block;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 4px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .contact-form textarea {
            resize: vertical;
            height: 120px;
        }

        .contact-form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 16px;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 12px;
        }

        .contact-form button:hover {
            background-color: #0056b3;
        }

        .error-list {
            background-color: #ffdddd;
            border-left: 4px solid #d8000c;
            color: #d8000c;
            padding: 8px;
            margin-bottom: 12px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .success-message {
            background-color: #ddffdd;
            border-left: 4px solid #006400;
            color: #006400;
            padding: 8px;
            margin-bottom: 12px;
            border-radius: 4px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <form class="contact-form" action="contact.php" method="POST">
        <h2>Contact Me</h2>

        <!-- 2) Display validation errors, if any -->
        <?php if (!empty($errors)): ?>
            <div class="error-list">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- 3) Display success message on successful send -->
        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <p><?php echo htmlspecialchars($success_message); ?></p>
            </div>
        <?php endif; ?>

        <!-- 4) Name field (re-populated on error) -->
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" placeholder="John Doe"
            value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>

        <!-- 5) Email field (re-populated on error) -->
        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" placeholder="you@example.com"
            value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>

        <!-- 6) Message field (re-populated on error) -->
        <label for="message">Your Message:</label>
        <textarea id="message" name="message" placeholder="Write your message here..."
            required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>

        <!-- 7) Submit button -->
        <button type="submit">Send Message</button>
    </form>

</body>

</html>