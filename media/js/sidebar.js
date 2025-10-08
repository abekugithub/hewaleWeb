/* 
Developed By: Qwesi Gyan
 */
function openNav() {
    document.getElementById("mySidenav").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    document.getElementById("open").style.display = "none";
    document.getElementById("close").style.display = "block";
    document.getElementById("mopen").style.display = "none";
    document.getElementById("mclose").style.display = "block";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
    document.getElementById("open").style.display = "block";
    document.getElementById("close").style.display = "none";
    document.getElementById("mopen").style.display = "block";
    document.getElementById("mclose").style.display = "none";
}

$(document).ready(function() {
    $('.fa-spin-hover').hover(function() {
        $(this).addClass('fa-spin');
    }, function() {
        $(this).removeClass('fa-spin');
    });

})