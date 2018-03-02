function passwordValidation(){
    var password = document.getElementById('password').value;
    var validation = false;

    if (password != "")
    {
        validation = true;
    }
    else {
        alert("Please fill in the password field");
    }

    return validation;
}