$( ".select1" ).click(function() {
    $("#chapter_admin").css( { display: 'block' });
    $("#comment_admin, #users_admin, #news_admin").css( { display: 'none' });
    $(this).addClass("active");
    for (let i=1 ; i<5 ; i++) {
        if (i != 1){
            $(".select" + i).removeClass("active");
        }
    }
});

$( ".select2" ).click(function() {
    $("#comment_admin").css( { display: 'block' });
    $("#chapter_admin, #users_admin, #news_admin").css( { display: 'none' });
    $(this).addClass("active");
    for (let i=1 ; i<5 ; i++) {
        if (i != 2){
            $(".select" + i).removeClass("active");
        }
    }
});

$( ".select3" ).click(function() {
    $("#users_admin").css( { display: 'block' });
    $("#comment_admin, #chapter_admin, #news_admin").css( { display: 'none' });
    $(this).addClass("active");
    for (let i=1 ; i<5 ; i++) {
        if (i != 3){
            $(".select" + i).removeClass("active");
        }
    }
});

$( ".select4" ).click(function() {

    $("#news_admin").css( { display: 'block' });
    $("#comment_admin, #chapter_admin, #users_admin").css( { display: 'none' });

    $(this).addClass("active");
    for (let i=1 ; i<5 ; i++) {
        if (i != 4){
            $(".select" + i).removeClass("active");
        }
    }
});

$(".commandSupprChapter").on('click', function() {

    $.confirm({
        title: 'Confirm!',
        content: 'Simple confirm!',
        buttons: {
            confirm: function () {
                $.alert('Confirmed!');
            },
            cancel: function () {
                $.alert('Canceled!');
            },
            somethingElse: {
                text: 'Something else',
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function(){
                    $.alert('Something else?');
                }
            }
        }
    });
})