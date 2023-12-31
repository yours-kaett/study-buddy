<!DOCTYPE html>
<html lang="en">

<head>
    <title>ICT Study-Buddy</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/ICT-StudyBuddyLogo.ico">
</head>

<body>
    <main>
        <div class="container starters min-vh-100">
            <img src="img/ICT-StudyBuddyLogo.png" width="100" alt="Study Buddy Logo">
            <h3 class="fw-bold mt-4">Teacher</h3>
            <div class="card">
                <form action="backend/teacher-signup-sanitize.php" method="POST" class="mb-4">
                    <div class="w-100">
                        <input type="email" name="email" placeholder="Email" class="starters-input mb-2 w-100 me-5 mt-2" required>
                    </div>
                    <div class="w-100">
                        <input type="text" name="username" placeholder="Username" class="starters-input mb-2 w-100 me-5" required>
                    </div>
                    <div class="w-100">
                        <input type="password" name="password" placeholder="Password" class="starters-input mb-2 w-100 me-5" required>
                    </div>
                    <div class="w-100 mt-3">
                        <button class="btn-login w-100 me-5 d-flex align-items-center justify-content-center" type="submit" onclick="submitFn()">
                            <span id="create">Create</span>
                            <span id="spinner" style="display: none; padding: 9px;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
                <div class="container d-flex justify-content-center mt-3">
                    <p>Has already an account? <strong><a href="teacher-login.php">Login here.</a></strong></p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php
        if (isset($_GET['success'])) {
        ?>
            <div class="alert alert-primary alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0 fixed-bottom" role="alert">
                <span class="text-primary"><?php echo $_GET['success'], "Account created successfully."; ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
        if (isset($_GET['taken'])) {
        ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0 fixed-bottom" role="alert">
                <span class="text-danger"><?php echo $_GET['taken'], "Username already taken."; ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
        if (isset($_GET['unknown'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0 fixed-bottom" role="alert">
                <span class="text-danger"><?php echo $_GET['unknown'], "Unknown error occured."; ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
        ?>
    </footer>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script>
        function submitFn() {
            document.getElementById('create').style.display = "none"
            document.getElementById('spinner').style.display = "flex"
            document.getElementById('spinner').style.alignItems = "center"
            document.getElementById('spinner').style.justifyContent = "center"
        }
    </script>
</body>

</html>