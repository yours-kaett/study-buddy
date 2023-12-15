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

let signup_email = document.getElementById("email");
let signup_username = document.getElementById("username");
let signup_password = document.getElementById("password");
let signup_submit = document.getElementById("submit");
function signup_data() {
    const emailValue = signup_email.value.trim();
    const usernameValue = signup_username.value.trim();
    const passwordValue = signup_password.value.trim();
    if (emailValue !== '' && usernameValue !== '' && passwordValue !== '') {
        signup_submit.removeAttribute('disabled');
        signup_submit.classList.remove("bg-secondary");
        signup_submit.style.color = "#d9fef2";
        signup_submit.style.cursor = "pointer";
    } else {
        signup_submit.setAttribute('disabled', 'disabled');
        signup_submit.classList.add("bg-secondary");
        signup_submit.style.color = "#cccccc";
        signup_submit.style.cursor = "not-allowed";
    }
}
username.addEventListener("input", signup_data);
password.addEventListener("input", signup_data);
signup_data();


function submitFn() {
    document.getElementById('login').style.display = "none"
    document.getElementById('loading').style.display = "flex"
    document.getElementById('loading').style.alignItems = "center"
    document.getElementById('loading').style.justifyContent = "center"
}
