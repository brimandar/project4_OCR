//Infinite Scroll
// initialize a var ajaxready to true at the first loading of the function
$(window).data('ajaxready', true);

$(window).scroll(function () {

    // if ajaxready is false, stop function
    if ($(window).data('ajaxready') == false) return;

    let lastId = parseInt($(".item").last().attr('id'));//Last comment load
    let chapterId = encodeURIComponent($(".singlechapterId").html());

    // End of the document reached?
    if ($(document).height() - $(this).height() == $(this).scrollTop()) {

        // when the script start, set ajaxreayd to false. So, navigator can't run another task
        $(window).data('ajaxready', false);

        $("#loader").show();
        // If end page, add comments with AJAX
        $.ajax({
            url: "../public/index.php?route=commentaires&chapterId=" + chapterId + "&lastId=" + lastId,
            success: function (html) 
            {
                if(html){
                    console.log(lastId);
                    $(".post").last().append(html);
                    $("#loader").hide();
                    // set ajaxready to false to continue
                    $(window).data('ajaxready', true);
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

//Scroll Indicator : capture scroll any percentage
$(window).scroll(function(){
    var wintop = $(window).scrollTop(), docheight = 
        
        $(document).height(), winheight = $(window).height();
                 var scrolled = (wintop/(docheight-winheight))*100;
      
              $('.scroll-line').css('width', (scrolled + '%'));
    });