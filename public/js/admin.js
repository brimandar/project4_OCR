//Load JQuery plugin DataTable
$( document ).ready(function() {
  $('#table_chapters_admin, #table_users_admin, #table_newsletters_admin').DataTable( {
    "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    responsive: true,
    "language": 
    {
      "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
    }
    });
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



// Function Delete (chapter, users, News)
function deleteElt(selectorElt, route, keyId){
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
            title: 'Supprimer un chapitre ?',
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
                            url: '../public/index.php?',
                            type: 'GET',
                            data: data,

                            success: function(){
                            // Remove row from HTML Table
                            $(el).closest('tr').css('background','tomato');
                            $(el).closest('tr').fadeOut(800,function(){
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
deleteElt(".commandSupprChapter_", 'deleteChapter', 'chapterId');
// Delete Newsletter
deleteElt(".btnDeleteNews_", 'deleteNews', 'newsId');
// Delete User
deleteElt(".btnDeleteUser_", 'deleteUser', 'userId');
