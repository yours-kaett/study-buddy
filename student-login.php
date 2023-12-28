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

<header>
    <!-- errors -->
    <?php
    if (isset($_GET['invalid'])) {
    ?>
        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center fixed-top rounded-0 mb-2 w-100" role="alert">
            <span class="text-secondary"><?php echo $_GET['invalid'], "Invalid username or password."; ?>
            <a href="student-login.php">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </a>
        </div>
    <?php
    }
    if (isset($_GET['unknown'])) {
    ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fixed-top rounded-0 mb-2 w-100" role="alert">
            <span class="text-danger"><?php echo $_GET['unknown'], "Unknown error occured."; ?>
            <a href="student-login.php">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </a>
        </div>
    <?php
    }
    if (isset($_GET['error'])) {
    ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fixed-top rounded-0 mb-2 w-100" role="alert">
            <span class="text-secondary"><?php echo $_GET['error']; ?>
            <a href="student-login.php">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </a>
        </div>
    <?php
    }
    ?>
</header>

<body>
    <main>
        <div class="container starters min-vh-100">
            <img src="img/ICT-StudyBuddyLogo.png" width="100" alt="Study Buddy Logo">
            <h3 class="fw-bold mt-4">Student</h3>
            <div class="card">
                <form action="backend/student-login-sanitize.php" method="POST" class="mb-4">
                    <div class="w-100">
                        <input type="text" name="username" id="username" placeholder="Username" class="starters-input mb-2 w-100 me-5 mt-2">
                    </div>
                    <div class="w-100">
                        <input type="password" name="password" id="password" placeholder="Password" class="starters-input mb-2 w-100 me-5">
                    </div>
                    <div class="w-100 mt-3">
                        <button class="btn-login w-100 me-5 d-flex align-items-center justify-content-center" id="submit" type="submit" onclick="submitFn()">
                            <span id="login">Login</span>
                            <span id="spinner" style="display: none; padding: 9px;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
                <div class="container d-flex flex-column mt-2">
                    <p>Don't have an account yet? <strong><a href="student-signup.php">Sign up</a></strong> now.</p>
                    <span class="d-flex justify-content-center">
                        <a href="choose-user.php">
                            <i class="bx bx-left-arrow"></i>Back to main
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <!-- success & error -->
    </main>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script>
        let username = document.getElementById("username");
        let password = document.getElementById("password");
        let submit = document.getElementById("submit");

        function login_data() {
            const usernameValue = username.value.trim();
            const passwordValue = password.value.trim();
            if (usernameValue !== '' && passwordValue !== '') {
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
        username.addEventListener("input", login_data);
        password.addEventListener("input", login_data);
        login_data();

        function submitFn() {
            document.getElementById('login').style.display = "none"
            document.getElementById('spinner').style.display = "flex"
            document.getElementById('spinner').style.alignItems = "center"
            document.getElementById('spinner').style.justifyContent = "center"
        }
    </script>

</body>

</html>