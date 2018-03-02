function registerValidation()
{
    var validation = false;

    var username = document.getElementById('username').value;
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('password2').value;
    var phone = document.getElementById('phone').value;

    var usernameValidation = false;
    var passwordValidation = false;
    var nameValidation = false;
    var emailValidation = false;
    var phoneValidation = false;


    ///////////////// NAME ////////////////////
    if (verifyName(name) == true)
    {
        nameValidation = true;
        document.getElementById("name").style.borderColor = 'green';
        document.getElementById("name").style.borderStyle = "solid, 2px";
    } else {
        document.getElementById("name").style.borderColor = 'red';
        document.getElementById("name").style.borderStyle = "solid, 2px";
    }

    function verifyName(name)
    {
        var valid = false;

        if (name != "")
        {
            valid = true;
        }

        return valid;

    }

    ///////////////PHONE VALIDATION///////////////
    if (verifyNumber(phone) == true) {
        phoneValidation = true;
        document.getElementById("phone").style.borderColor = 'green';
        document.getElementById("phone").style.borderStyle = "solid, 5px";
    } else {
        document.getElementById("phone").style.borderColor = 'red';
        document.getElementById("phone").style.borderStyle = "solid, 2px";
    }

    ////////////////EMAIL//////////////////
    if (verifyEmail(email) == true)
    {
        emailValidation = true;
        document.getElementById("email").style.borderColor = 'green';
        document.getElementById("email").style.borderStyle = "solid, 2px";
    } else {
        document.getElementById("email").style.borderColor = 'red';
        document.getElementById("email").style.borderStyle = "solid, 2px";
    }

    function verifyEmail(email)
    {
        var valid = false;

        if (email != "")
        {
            valid = true;
        }

        return valid;

    }


    ///////////USERNAME/////////////////////
    if (verifyUserName(username) == true)
    {
        usernameValidation = true;
        document.getElementById("username").style.borderColor = 'green';
        document.getElementById("username").style.borderStyle = "solid, 2px";
    } else {
        document.getElementById("username").style.borderColor = 'red';
        document.getElementById("username").style.borderStyle = "solid, 2px";
    }

    function verifyUserName(username)
    {
        var valid = false;

        if (username != "")
        {
            valid = true;
        }

        return valid;

    }


    function verifyNumber(phone)
    {
        var valid = false;

        if (phone != "")
        {
            var phoneNo = /^\d{10}$/;

            if(phone.match(phoneNo))
            {
                valid = true;
            }
            else
            {
                alert("Phone Number needs to be 10 characters long");
            }
        }

        return valid;
    }

    //////////////PASSWORD///////////////////
    if (verifyPassword(password, confirmPassword) == true)
    {
        passwordValidation = true;
        document.getElementById("password").style.borderColor = 'green';
        document.getElementById("password2").style.borderColor = 'green';
        document.getElementById("password").style.borderStyle = "solid, 2px";
        document.getElementById("password2").style.borderStyle = "solid, 2px";
    } else {
        document.getElementById("password2").style.borderColor = 'red';
        document.getElementById("password2").style.borderStyle = "solid, 2px";
        document.getElementById("password").style.borderColor = 'red';
        document.getElementById("password").style.borderStyle = "solid, 2px";
    }

    function verifyPassword(password, confirmPassword)
    {
        var valid = false;

        if (password != "")
        {
            if (password.valueOf() == confirmPassword.valueOf())
            {
                valid = true;
            }

            else
            {
                alert("Passwords do not match");
            }
        }

        return valid;
    }

    if (formValidation() == true)
    {
        validation = true;
    }

    function formValidation()
    {
        var formValidation = false;

        if (usernameValidation == true && passwordValidation == true && nameValidation == true && emailValidation == true && phoneValidation == true)
        {
            formValidation = true;
        }

        return formValidation;
    }

    return validation;
}