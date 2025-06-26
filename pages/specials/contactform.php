<form class="form disabled contact-form" action="contact.php" method="POST">
    <h3 class="headline">Contact me</h3>

    <!-- Display validation errors, if any -->
    <?php if (!empty($errors)): ?>
        <div class="error-list">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Display success message, if email sent -->
    <?php if (!empty($success_message)): ?>
        <div class="success-message">
            <p><?php echo htmlspecialchars($success_message); ?></p>
        </div>
    <?php endif; ?>

    <!-- Name field -->
    <label for="name">Your Name:</label>
    <input disabled class="input" type="text" id="name" name="name" placeholder="John Doe"
        value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>

    <!-- Email field -->
    <label for="email">Your Email:</label>
    <input disabled class="input" type="email" id="email" name="email" placeholder="you@example.com"
        value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>

    <!-- Message field -->
    <label for="message">Your Message:</label>
    <textarea disabled id="message" name="message" placeholder="Write your message here..."
        required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>

    <!-- Submit button -->
    <button disabled type="cta submit">Send Message</button>
</form>