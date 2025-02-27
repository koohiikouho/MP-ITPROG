

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

    //HELLOW
    $('#searchBuild').click(function() {
        buildID = prompt("Enter Build ID");
        var string = "";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                string = this.responseText;    
                string = string.replace(/<\/?[^>]+(>|$)/g, "");
                alert(string);         
            }
        };

        xmlhttp.open("GET", "./php/viewBuild.php?buildID=" + buildID, true);
        xmlhttp.send();
        
        
        

    });


});
