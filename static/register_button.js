function validateEmail(a) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (a !== '' && regex.test(a)) {
        return true;
    }
    return false;
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


document.getElementById("RegisterForm").addEventListener("submit", event => {
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


    fetch('../register.php', { method: 'POST', body: JSON.stringify(userData) })
        .then(r => r.json())
        .then(response => {
            if (response.error) { // registration failed
                event.target.querySelector('.error-message').innerText = response.error;
                event.target.querySelector('.success-message').innerText = '';
            } else {
                event.target.querySelector('.error-message').innerText = '';
                event.target.querySelector('.success-message').innerText = 'Successful registration. You can now ';
                let link = document.createElement("a");
                link.appendChild(document.createTextNode("log in"));
                link.href = "./login.html";
                event.target.querySelector('.success-message').appendChild(link);
            }
        });
});


