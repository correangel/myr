$(document).ready(function() {

	$("tbody").addClass("searchable");

  (function($) {

    $('#filter').keyup(function() {
    	//alert($('#filter').val());

      var rex = new RegExp($(this).val(), 'i');
      $('.searchable tr').hide();
      $('.searchable tr').filter(function() {
        return rex.test($(this).text());
      }).show();

    })

  }(jQuery));

});
