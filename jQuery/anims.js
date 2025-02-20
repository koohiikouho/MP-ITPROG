

$(document).ready(function(){
    setTimeout(function(){
        $('#myNavbar').addClass('show');
    }, 500);
    setTimeout(function(){
        $('#myInput').addClass('show');
    }, 1000);           
    setTimeout(function(){
        $('#myFooter').addClass('show');
    }, 500);  

    setTimeout(function(){
        $('#navbarShadow').addClass('show');
    }, 500);  

    $('#sidediv').scroll(function() { 
        $('#sidecard').animate({top:$(this).scrollTop()},100,"linear");
    })

});
