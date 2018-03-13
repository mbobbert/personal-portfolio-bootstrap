$('a[href^="#"]').on('click', function(event) {
    var target = $(this.getAttribute('href'));
    if( target.length ) {
        event.preventDefault();
        $('html, body').stop().animate({
            scrollTop: target.offset().top
        }, 2000);
    }
});



$('#progress-evolution').appear();

function progress(barID, value) {
    $(barID).animate({'width': value}, 2000);
}

$('#progress-evolution').on('appear', function() {
    progress('#bar-HTML', '80%');
    progress('#bar-CSS', '80%');
    progress('#bar-Javascript', '75%');
    progress('#bar-React', '70%');
    progress('#bar-jQuery', '75%');
    progress('#bar-PHP', '85%');
    progress('#bar-Laravel', '85%');
    progress('#bar-UX', '80%');
});

