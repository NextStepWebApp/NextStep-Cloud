<?php
require_once "../utils.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/logo.webp"/>
    <link rel="stylesheet" href="../css/style.css"/>
    <title>NextStep Alumni Portal — Submit Your Information</title>

</head>
<body>

    <nav class="navbar">
        <a href="<?php echo $base_url; ?>" class="nav-brand">NextStep</a>
    </nav>

    <div class="portal-wrapper">
        <div class="portal-card">

            <!-- HEADER -->
            <div class="portal-header">
                <h1>Alumni Portal</h1>
                <p>Update your post-graduation information with your school</p>
            </div>

            <!-- ERROR MESSAGE (hidden by default) -->
            <div class="error-message" id="error-message">
                Invalid access code. Please check your code and try again.
            </div>

            <!-- FORM -->
            <form id="alumni-form" action="/alumni/verify" method="POST">

                <div class="form-group">
                    <label class="form-label" for="school">Select Your School</label>
                    <select class="form-select" id="school" name="school" required>
                        <option value="" disabled selected>Choose your school...</option>
                        <option value="sunshine-high">Sunshine High School — Amsterdam, NL</option>
                        <option value="sunrise-academy">Sunrise Academy — Rotterdam, NL</option>
                        <option value="st-marys">St. Mary's School — London, UK</option>
                        <option value="riverdale">Riverdale High — Berlin, DE</option>
                        <option value="oakwood">Oakwood College — Paris, FR</option>
                        <option value="greenfield">Greenfield Academy — Madrid, ES</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="code">Access Code</label>
                    <input type="text" class="form-input" id="code" name="code"
                        placeholder="Enter your access code (e.g. ABC-123-XYZ)"
                        maxlength="20" required>
                    <p class="form-hint">You should have received this code from your school</p>
                </div>

                <button type="submit" class="submit-btn">Continue to Form</button>

            </form>

            <div class="divider">or</div>

            <div class="direct-link">
                <p>Have a direct link from your school?</p>
                <a href="#">Click here to use your direct link</a>
            </div>

        </div>
    </div>

    <footer class="portal-footer">
        <p>Powered by <a href="/">NextStep</a> — Alumni Tracking Cloud Bridge</p>
    </footer>

    <script>
        // Demo: show error on invalid code (for frontend testing)
        document.getElementById('alumni-form').addEventListener('submit', function(e) {
            // In production, remove this and let the form submit normally
            // This is just for demo purposes
            const code = document.getElementById('code').value;
            if (code.toLowerCase() === 'invalid') {
                e.preventDefault();
                document.getElementById('error-message').classList.add('active');
            }
        });
    </script>

</body>
</html>