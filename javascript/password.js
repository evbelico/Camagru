let submitBtn = document.getElementById('submit-btn');

submitBtn.onclick = function () {
    let email = document.getElementById('e-mail').value;
    let password = document.getElementById('pwd').value;
    let passwordConfirm = document.getElementById('pwd-confirm').value;
    let regex = /^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-zA-Z]).{8,50}$/gm;

    if (email.length == 0 || email == '')
        alert("Enter your e-mail address, please.");
    else if (password.search(regex) == -1 || passwordConfirm.search(regex) == -1)
        alert("Your password should contain 8 to 50 characters and be composed of at least one capital letter, one small letter and one special character such as : !@#$%^&*-");
    else if (password.length < 8 || password.length > 50)
        alert("Your password should contain 8 to 50 characters.");
    else if (passwordConfirm != password)
        alert("Passwords do not match, try again");
    /*else
        ajaxPasswordToBack(email, password, passwordConfirm);*/
}

/*function ajaxPasswordToBack(email, password, passwordConfirm) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "actions/forgot.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("mail=" + email + "&password=" + password + "&password-confirm=" + passwordConfirm);
}*/