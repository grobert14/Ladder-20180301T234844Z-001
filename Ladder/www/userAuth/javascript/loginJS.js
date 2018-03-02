function loginValidation()
{
    var validation = false;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var usernameValidation = false;
    var passwordValidation = false;


    if (verifyUserName(username) == true)
    {
        usernameValidation = true;
    }

    else
    {
        alert("Enter a valid username");
    }

    if (verifyPassword(password) == true)
    {
        passwordValidation = true;
    }

    else
    {
        alert("Password not valid");
    }

    function verifyUserName(username)
    {
        var nameValidation = false;
        if (username != "")
        {
            nameValidation = true;
        }

        return nameValidation;

    }

    function verifyPassword(password)
    {
        var passwordValidation = false;

        if (password != "")
        {
            passwordValidation = true;
        }

        return passwordValidation;
    }

    if (formValidation(usernameValidation, passwordValidation) == true)
    {
        validation = true;
    }

    function formValidation(usernameValidation, passwordValidation)
    {
        var formValidation = false;

        if (usernameValidation == true && passwordValidation == true)
        {
            validation = true;
        }

        return formValidation;
    }

    return validation;
}