//Infinite Scroll
$(window).scroll(function () {

    let chapterId = encodeURIComponent($(".singlechapterId").html());
    let lastId = $(".item").last().attr('id');//Last comment load

    // End of the document reached?
    if ($(document).height() - $(this).height() == $(this).scrollTop()) {
        $("#loader").show();
        // If end page, add comments with AJAX
        $.ajax({
            url: "../public/index.php?route=commentaires&chapterId=" + chapterId + "&lastId=" + lastId,
            success: function (html) 
            {
                if(html){
                    $(".post").append(html);
                    $("#loader").hide();
                } else {
                    $("#loader").hide();
                    return;
                }
                
            },
            error: function (req, status, error) 
            {
                alert("Erreur de chargement des commentaires");
            }
        });
    }
})

// Add a comment
$("#formAddCommentUser").submit(function(e) 
{
    e.preventDefault();
    let chapterId = $(".singlechapterId").html();
    let user = $('.userIdentification').html();
    let message =  $('.content').val() ;
    console.log(user);
    $.ajax({
        url: "../public/index.php?route=addComment&chapterId=" + chapterId,
        type: 'POST',
        data : "content=" + message, // et on envoie nos données
        success: function (data) 
        {
            $( "<h4>" + user + "</h4>" + "<p>" + message + "</p>" + "<p>Posté à l'instant</p>" ).insertBefore( ".post" );
            
        },
        error: function (req, status, error) 
        {
            alert("Erreur de chargement des commentaires");
        }
    });
})
