function validateEmail(a) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    console.log(regex.test(email))
    if (a === '' || regex.test(email)) {
        return false;
    }
    return true;
}

function validateUsername(a) {
    if (a === '' || a.length < 6) {
        return false;
    }
    return true;
}

function validatePassword(a) {
    if (a === '0' || a.length < 8) {
        return false;
    }
    return true;
}


document.getElementById("loginForm").addEventListener("submit", event => {
    event.preventDefault();

    let userData = {
        'email': event.target.querySelector('input[name="email"]').value,
        'username': event.target.querySelector('input[name="username"]').value,
        'password': event.target.querySelector('input[name="password"]').value
    };

    if (!validateEmail(userData.email)) {
        event.target.querySelector('.error-message').innerText = "Email is not valid!";
        event.target.querySelector('.success-message').innerText = '';
        return;
    }

    if (!validateUsername(userData.username)) {
        event.target.querySelector('.error-message').innerText = "The username is not in the correct format.";
        event.target.querySelector('.success-message').innerText = '';
        return;
    }

    if (!validatePassword(userData.password)) {
        event.target.querySelector('.error-message').innerText = "The password is not in the correct format.";
        event.target.querySelector('.success-message').innerText = '';
        return;
    }


    fetch('../login.php', { method: 'POST', body: JSON.stringify(userData) })
        .then(r => r.json())
        .then(response => {
            if (response.redirect) {
                window.location.href = response.redirect;
            } else if (response.success === false) {
                //It doesn't display the correct message, if a combination of a correct name and a wrong password is entered.
                event.target.querySelector('.error-message').innerText = "There is no user with this name.";
                event.target.querySelector('.success-message').innerText = '';
            }
        });
});