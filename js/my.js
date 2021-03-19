// Modificació classes al redimensionar la finestra
var win = $(this);
var nav = $('#navButtons');
var navDropdown = $('#profile');
var mainSection = $('#main');
var square = $('#square');

function switchNavbar() {
    if (win.width() < 768) {
        nav.removeClass();
        nav.addClass('navbar navbar-expand fixed-bottom navbar-dark mb-0 bg-dark ms-auto list-unstyled d-flex justify-content-center');
        mainSection.removeClass('py-5');
        mainSection.addClass('py-m');
        navDropdown.removeClass('dropdown');
        navDropdown.addClass('dropup');
        square.removeClass('square');
        square.addClass('square-dropup');
    } else {
        nav.removeClass('navbar navbar-expand fixed-bottom navbar-dark mb-0 bg-dark ms-auto list-unstyled d-flex justify-content-center');
        nav.addClass('navbar-nav ms-auto mb-2 mb-lg-0');
        mainSection.removeClass('py-m');
        mainSection.addClass('py-5');
        navDropdown.removeClass('dropup');
        navDropdown.addClass('dropdown');
        square.removeClass('square-dropup');
        square.addClass('square');
    }
}

$(function() {
    switchNavbar();
});

$(window).on('resize', function(){
    switchNavbar();
});

// Mostrar el modal amb id "modal"
$(document).ready(function(){
    $("#modal").modal("show");
});