<!DOCTYPE html>
<html lang="en">

<head>
    <title>ICT Study-Buddy</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/ICT-StudyBuddyLogo.png">
</head>

<body>
    <main>
        <div class="container starters min-vh-100">
            <img src="img/ICT-StudyBuddyLogo.png" width="150" alt="Study Buddy Logo">
            <h4 class="fw-bold mt-4">Login as</h4>
            <div class="card">
                <a href="student-login.php">
                    <button class="btn-b w-100 me-5">
                        <span>
                            <i class="bx bxs-backpack"></i>&nbsp; Student
                        </span>
                    </button>
                </a>
                <a href="teacher-login.php">
                    <button class="btn-a w-100 me-5 mt-2 mb-2">
                        <span>
                            <i class="bx bxs-briefcase"></i>&nbsp; Teacher
                        </span>
                    </button>
                </a>
            </div>
            <div id="content"></div>
        </div>
    </main>

</body>

</html>