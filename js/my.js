var win = $(this);
var nav = $('#navButtons');
var navDropdown = $('#profile');

function switchNavbar() {
    if (win.width() < 768) {
        nav.addClass('navbar navbar-expand fixed-bottom navbar-dark bg-dark ms-auto d-flex justify-content-center');
        navDropdown.removeClass('dropdown');
        navDropdown.addClass('dropup');
    } else {
        nav.removeClass('navbar navbar-expand fixed-bottom navbar-dark bg-dark ms-auto d-flex justify-content-center');
        navDropdown.removeClass('dropup');
        navDropdown.addClass('dropdown');
    }
}

$(function() {
    switchNavbar();
});

$(window).on('resize', function(){
    switchNavbar();
});