$( document ).ready(function() {
    $('#allChaptersTable').DataTable( {
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "language": 
      {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
      },
      });

    let url = window.location.href;
    let route = "pageUsers";
    if(url.includes(route))
    {
        selectedAdmin(".select3","#users_admin","#comment_admin, #chapter_admin, #news_admin",3)
    }
  });