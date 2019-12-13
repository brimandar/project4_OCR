function afficherMessageConfirmation() 
{
  $(".messageConfirmation").animate({
      height: "100px",
      opacity: "1"
  });
  $(".messageConfirmation").css({
      marginBottom: '15px'
  });

    setTimeout(function() 
    { 
    $(".messageConfirmation").animate({
        height: "1px",
        opacity: "0"
        }); 
    $(".messageConfirmation").css({
        marginBottom: '0px'
    })
    }, 1500); 


}

