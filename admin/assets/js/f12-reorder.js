jQuery(document).ready(function ($) {
    var pageTitle = $("div h1");
    var sortList = $(".f12-sortable");
    sortList.sortable({
        update:function(event,ui){
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'f12r_reference_sort',
                    order: sortList.sortable('toArray').toString()
                },
                success:function(response){
                    console.log("updated sort");
                    pageTitle.after("<div class='updated'><p>Reihenfolge aktualisiert.</p></div>")
                },
                error:function(err){
                    console.log(err);
                    pageTitle.after("<div class='error'><p>Reihenfolge konnte nicht aktualisiert werden.</p></div>")
                }
            });
        }
    });
});