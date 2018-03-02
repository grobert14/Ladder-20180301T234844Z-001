function scoreValidation()
{
    var challengerScore = document.getElementById('challengerScore').value;
    var challengeeScore = document.getElementById('challengeeScore').value;

    validation = false;

    if (challengerScore != "" && challengeeScore != "")
    {
        challengeeScore = parseInt(challengeeScore);
        challengerScore = parseInt(challengerScore);
        if (challengerScore >= 15 || challengeeScore >= 15) {
            if (Math.abs(challengeeScore - challengerScore) >= 2) {
                validation = true;
            }
            else
            {
                alert("Difference between scores need to be 2 points!")
            }
        }

        else
        {
            alert("Minimum score needs to be 15")
        }
    }

    else
    {
        alert("Please make sure to have both scores filled out!")
    }

    return validation;


}