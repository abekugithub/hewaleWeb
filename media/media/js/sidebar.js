/* 
Developed By: Qwesi Gyan
 */
function openNav() {
    document.getElementById("mySidenav").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    document.getElementById("open").style.display = "none";
    document.getElementById("close").style.display = "block";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
    document.getElementById("close").style.display = "none";
    document.getElementById("open").style.display = "block";
}

$(document).ready(function() {
    $('.fa-spin-hover').hover(function() {
        $(this).addClass('fa-spin');
    }, function() {
        $(this).removeClass('fa-spin');
    });

})