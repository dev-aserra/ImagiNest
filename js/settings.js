// Modificació classes al redimensionar la finestra
var win = $(this);
var settings = document.querySelector('#settingsIcons');
var icons = settings.querySelectorAll('i');

function switchIcons() {
    if (win.width() < 425) {
        icons.forEach(function(i){
            i.classList.remove('fa-2x');
        })
    } else {
        icons.forEach(function(i){
            i.classList.add('fa-2x');
        })
    }
}

$(function() {
    switchIcons();
});

$(window).on('resize', function(){
    switchIcons();
});

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }