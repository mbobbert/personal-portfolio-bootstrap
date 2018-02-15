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
    progress('#bar-Javascript', '80%');
    progress('#bar-React', '80%');
    progress('#bar-jQuery', '80%');
    progress('#bar-PHP', '80%');
    progress('#bar-Laravel', '80%');
    progress('#bar-UX', '80%');
});

