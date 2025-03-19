

function populateCPU(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {
            
            document.getElementById("cpuBrand").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "../php/cpuInitBrand.php", true);
    xmlhttp.send();
    getCPUSockets();
};

function getCPUSockets(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {
            
            document.getElementById("cpuSocket").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/getSockets.php", true);
    xmlhttp.send();
};

function validSessionIDCheck(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {
            
           if(this.responseText == "Invalid")
                window.location.replace("../login.html");
        }
    };

    xmlhttp.open("GET", "./php/sesCheckJS.php", true);
    xmlhttp.send();

}
function popMem(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {
            fillAll = this.responseText;
            document.getElementById("memBrand").innerHTML = fillAll;
            document.getElementById("moboBrand").innerHTML = fillAll;
            document.getElementById("stoBrand").innerHTML = fillAll;
        }
    };

    xmlhttp.open("GET", "./php/getVendor.php", true);
    xmlhttp.send();
}

function populateCompBrand(){
    
    popMem();
    
}

$(document).ready(function(){
    
    validSessionIDCheck();
    populateCPU();
    populateCompBrand();

});