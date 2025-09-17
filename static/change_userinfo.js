const emailTab = document.getElementById("emailTab");
const passwordTab = document.getElementById("passwordTab");
const emailSection = document.getElementById("emailSection");
const passwordSection = document.getElementById("passwordSection");

emailTab.addEventListener("click", () => {
    emailTab.classList.add("active");
    passwordTab.classList.remove("active");
    emailSection.classList.add("active");
    passwordSection.classList.remove("active");
});

passwordTab.addEventListener("click", () => {
    passwordTab.classList.add("active");
    emailTab.classList.remove("active");
    passwordSection.classList.add("active");
    emailSection.classList.remove("active");
});


document.getElementById("changeEmailForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const newEmail = document.getElementById("newEmail").value;
    const confirmEmail = document.getElementById("confirmEmail").value;
    const errorMsg = e.target.querySelector(".error-message");
    const successMsg = e.target.querySelector(".success-message");
    errorMsg.textContent = "";
    successMsg.textContent = "";

    if (newEmail !== confirmEmail) {
        errorMsg.textContent = "Emails do not match.";
        return;
    }

    fetch("../change_email.php", {
        method: "POST",
        body: JSON.stringify({ newEmail })
    })
        .then(r => r.json())
        .then(response => {
            if (response.error) {
                errorMsg.textContent = response.error;
            } else if (response.success) {
                successMsg.textContent = "Email updated successfully.";
                e.target.reset();
            }
        })
        .catch(() => {
            errorMsg.textContent = "Server error. Please try again later.";
        });
});


document.getElementById("changePasswordForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const errorMsg = e.target.querySelector(".error-message");
    const successMsg = e.target.querySelector(".success-message");
    errorMsg.textContent = "";
    successMsg.textContent = "";

    if (newPassword !== confirmPassword) {
        errorMsg.textContent = "Passwords do not match.";
        return;
    }

    fetch("../change_password.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ newPassword })
    })
        .then(r => r.json())
        .then(response => {
            if (response.error) {
                errorMsg.textContent = response.error;
            } else if (response.success) {
                successMsg.textContent = "Password updated successfully.";
                e.target.reset();
            }
        })
        .catch(() => {
            errorMsg.textContent = "Server error. Please try again later.";
        });
});