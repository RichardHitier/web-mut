/**
    Copyright © 2015, 2016, 2017, 2018, 2019 Richard Hitier <hitier.richard@gmail.com>
    This work is free. You can redistribute it and/or modify it under the
    terms of the Do What The Fuck You Want To Public License, Version 2,
    as published by Sam Hocevar. See the COPYING file for more details.
**/
// send action on menu selection
$('select').change(
    function(){
         $(this).closest('form').trigger('submit');
});

// show results
$('#cdt').prepend( $('#hidden_cdt').text());

// neednt submit button if js activated
$("input[type='submit']").hide();

