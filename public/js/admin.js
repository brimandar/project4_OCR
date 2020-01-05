//Load JQuery plugin DataTable
function datatableLoad(selectors)  {
    $(selectors).DataTable( {
        "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        responsive: true,
        "language": 
        {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        }
        });
}

// Load only the menu displayed
$( document ).ready(function() {
    datatableLoad('#table_chapters_admin');
});

$( ".select2" ).click(function() {
    if($("#table-comments-profil" ).hasClass("dataTable")){
        return;
    } else {
    datatableLoad('#table-comments-profil');
    };
});

$( ".select3" ).click(function() {
    if($("#table_users_admin" ).hasClass("dataTable")){
        return;
    } else {
    datatableLoad('#table_users_admin');
    };
});

$( ".select4" ).click(function() {
    if($("#table_newsletters_admin" ).hasClass("dataTable")){
        return;
    } else {
        datatableLoad('#table_newsletters_admin');
    };
});


// To navigate between pages (display and active list item)
function selectedAdmin(selectorActif, selectorDisplay, selectorsNotDisplay, nbSelectActive){
    $(selectorDisplay).css( { display: 'block' });
    $(selectorsNotDisplay).css( { display: 'none' });
    $(selectorActif).addClass("active");
    for (let i=1 ; i<5 ; i++) {
        if (i != nbSelectActive){
            $(".select" + i).removeClass("active");
        }
    }
}

$( ".select1" ).click(function() {
    selectedAdmin(this,"#chapter_admin","#comment_admin, #users_admin, #news_admin",1)
});

$( ".select2" ).click(function() {
    selectedAdmin(this,"#comment_admin","#chapter_admin, #users_admin, #news_admin",2)
});

$( ".select3" ).click(function() {
    selectedAdmin(this,"#users_admin","#comment_admin, #chapter_admin, #news_admin",3)
});

$( ".select4" ).click(function() {
    selectedAdmin(this,"#news_admin","#comment_admin, #chapter_admin, #users_admin",4)
});



// Function Delete (chapter, comments, users, News)
function deleteElt(deleteMessage, selectorElt, route, keyId, removeDOmElt){
    $(selectorElt).click(function(){
        var el = this;
        var id = this.id;
        var splitid = id.split("_");

        // Select id
        var deleteid = splitid[1];

        var data = {}
        data ['route'] = route
        data [keyId] = deleteid

        $.confirm({
            title: deleteMessage,
            content: 'Attention, la suppression est définitive !',
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Supprimer',
                    btnClass: 'btn-red',
                    action: function(){
                        // AJAX Request
                        $.ajax({
                            url: 'accueil',
                            type: 'GET',
                            data: data,

                            success: function(){
                            // Remove row from HTML Table
                            $(el).closest(removeDOmElt).css('background','tomato');
                            $(el).closest(removeDOmElt).fadeOut(800,function(){
                            $(this).remove();
                            });
                            }
                        });
                    }
                },
                Retour: function () {
                }
            }
        });
    });
};
// Delete Chapter
deleteElt("Supprimer ce chapitre ?", ".commandSupprChapter_", 'deleteChapter', 'chapterId', 'tr');
// Delete Newsletter
deleteElt("Supprimer cette news ?", ".btnDeleteNews_", 'deleteNews', 'newsId', 'tr');
// Delete User
deleteElt("Supprimer cet utilisateur ?", ".btnDeleteUser_", 'deleteUser', 'userId', 'tr');
// Delete comment inappropriate
deleteElt("Supprimer ce commentaire ?", ".commandSupprCommentAdmin_", 'deleteComment', 'commentId', 'tr');
// Delete comment (single.php)
deleteElt("Supprimer ce commentaire ?", ".commandSupprComment_", 'deleteComment', 'commentId', 'div');
