$("#formRegister, #formUpdatePwd").submit(function(e) {
    if( $("#password").val() === $("#confirmpassword").val() ) {
        return;
      } else {
      $( "span" ).text( "Not valid!" ).show().fadeOut( 2000 );
      e.preventDefault();
    };
});