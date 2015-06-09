// send action on menu selection
$('select').change(
    function(){
         $(this).closest('form').trigger('submit');
});

// show results
$('#cdt').prepend( $('#hidden_cdt').text());

// neednt submit button if js activated
$("input[type='submit']").hide();

