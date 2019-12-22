$( document ).ready(function() {
  $('#table_chapters_admin, #table_users_admin, #table_newsletters_admin').DataTable( {
    "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    responsive: true,
    "language": 
    {
      "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
    }
    });
  let url = window.location.href;
  let route = "pageUsers";
  if(url.includes(route))
  {
      selectedAdmin(".select3","#users_admin","#comment_admin, #chapter_admin, #news_admin",3)
  }
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


$(".commandSupprChapter").on("click", function() {
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
              location.href = $(".command_delete_chapter_admin").attr('href');
            }
        },
        Retour: function () {
        }
    }
  });
});