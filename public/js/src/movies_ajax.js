/**
 * delete a movie in database
 * 
 */
function deleteFilm(idOfFilm)	{
    $('#divModalSaving').show();
    var dataToSend = {
        page : "films_ajax",
        bJSON : 1, 
        id_film: $("#idOfFilm"+idOfFilm).html()
    }
    $.ajax({
        type: "POST",
        url: "route.php",
        async: true,
        data: dataToSend,
        dataType: "json",
        cache: false,
    })
    .done(function(result) {
        if (result[0]["error"] != "")	{
            $('#divModalSaving').hide();
            alert("Erreur lors de la suppression de votre film. Vous allez être déconnecté.");

        }  else  {

            alert ("supression faite")
            $("#idOfFilm"+idOfFilm).parent().remove();

        }
    })
    .fail(function(err) {
        console.log('error : ' + err.status);
        alert("Erreur lors de la suppression de votre film. Vous allez être déconnecté.");

    });
}
