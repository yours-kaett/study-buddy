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
    <link rel="icon" href="img/ICT-StudyBuddyLogo.png">
</head>

<body>
    <header>
        <?php
        if (isset($_GET['success'])) {
        ?>
            <div class="alert alert-primary alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0 fixed-top mb-2" role="alert">
                <span class="text-primary"><?php echo $_GET['success'], "Account created successfully."; ?></span>
                <a href="student-signup.php">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        if (isset($_GET['taken'])) {
        ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0 fixed-top mb-2" role="alert">
                <span class="text-danger"><?php echo $_GET['taken'], "Username already taken."; ?></span>
                <a href="student-signup.php">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        if (isset($_GET['error'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0 fixed-top mb-2" role="alert">
                <span class="text-danger"><?php echo $_GET['error'], "Unknown error occured."; ?></span>
                <a href="student-signup.php">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        ?>
    </header>
    <main>
        <div class="container starters min-vh-100">
            <img src="img/ICT-StudyBuddyLogo.png" width="100" alt="Study Buddy Logo">
            <h3 class="fw-bold mt-4">Student</h3>
            <div class="card">
                <form action="backend/student-signup-sanitize.php" method="POST" class="mb-4">
                    <div class="w-100">
                        <input type="email" name="email" id="email" placeholder="Email" class="starters-input mb-3 w-100 me-5 mt-2" required>
                    </div>
                    <div class="w-100">
                        <input type="text" name="username" id="username" placeholder="Username" class="starters-input mb-3 w-100 me-5" required>
                    </div>
                    <div class="w-100">
                        <input type="password" name="password" id="password" placeholder="Password" class="starters-input mb-3 w-100 me-5" required>
                    </div>
                    <div class="w-100">
                        <button class="btn-login w-100 me-5 d-flex align-items-center justify-content-center" id="submit" type="submit" onclick="submitFn()">
                            <span id="create">Create</span>
                            <span id="spinner" style="display: none; padding: 9px;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
                <div class="container d-flex justify-content-center mt-3">
                    <p>Has already an account? <strong><a href="student-login.php">Login here.</a></strong></p>
                </div>
            </div>
        </div>
    </main>
<<<<<<< HEAD
=======
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
>>>>>>> a489d5cbdc8c00dc8f796aab1f2ebff76150d395
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script>
        let email = document.getElementById("email");
        let username = document.getElementById("username");
        let password = document.getElementById("password");
        let submit = document.getElementById("submit");

        function signup_data() {
            const emailValue = email.value.trim();
            const usernameValue = username.value.trim();
            const passwordValue = password.value.trim();
            if (emailValue !== '' && usernameValue !== '' && passwordValue !== '') {
                submit.removeAttribute('disabled');
                submit.classList.remove("bg-secondary");
                submit.style.color = "#d9fef2";
                submit.style.cursor = "pointer";
            } else {
                submit.setAttribute('disabled', 'disabled');
                submit.classList.add("bg-secondary");
                submit.style.color = "#cccccc";
                submit.style.cursor = "not-allowed";
            }
        }
        email.addEventListener("input", signup_data);
        username.addEventListener("input", signup_data);
        password.addEventListener("input", signup_data);
        signup_data();

        function submitFn() {
            document.getElementById('login').style.display = "none"
            document.getElementById('spinner').style.display = "flex"
            document.getElementById('spinner').style.alignItems = "center"
            document.getElementById('spinner').style.justifyContent = "center"
        }
    </script>
</body>

</html>