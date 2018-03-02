function dateValidation(){
    var isValid = false;

    var scheduledTime = document.getElementById('challengeDateTime').value;
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date+' '+time;

    if (scheduledTime != ""){
        if(scheduledTime.match(/^([12]\d{3})-(0[0-9]|1[0-2])-(0[0-9]|1[0-9]|2[0-9]|3[0-1])(\s)([0-1]?[0-9]|2?[0-3]):([0-5]\d):([0-5]\d)/))
        {
            if (scheduledTime > dateTime)
            {
                isValid = true;
            }

            else
            {
                alert ("Date needs to after: " + scheduledTime);
            }

        }

        else
        {
            alert("Date Format needs to be: YY-MM-DD HH:MM:SS")
        }
    }

    else
    {
        alert("Please Enter a Date");
    }

    return isValid;

}