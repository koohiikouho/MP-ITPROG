

function populateCPU(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {
            
            document.getElementById("cpuBrand").innerHTML = this.responseText;
            
        }
    };

    xmlhttp.open("GET", "../php/cpuInitBrand.php", true);
    xmlhttp.send();


};

function getCPUSockets(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {
            
            document.getElementById("cpuSocket").innerHTML = this.responseText;
            document.getElementById("moboScoket").innerHTML = this.responseText;
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
            document.getElementById("psuBrand").innerHTML = fillAll;
            document.getElementById("caseBrand").innerHTML = fillAll;
            document.getElementById("gpuVendor").innerHTML = fillAll;
            document.getElementById("gpuBrand").innerHTML = fillAll;

        }
    };

    xmlhttp.open("GET", "./php/getVendor.php", true);
    xmlhttp.send();
}


$(document).ready(function(){

    validSessionIDCheck();
    populateCPU();
    getCPUSockets();
    popMem();


    $('#cpuAdd').click(function(){
        var cpuName = document.getElementById("cpuName").value;
        var cpuBrand = document.getElementById("cpuBrand");
        var cpuBrandText = cpuBrand.options[cpuBrand.selectedIndex].value;
        var cpuCores = document.getElementById("cpuCores").value;
        var cpuThreads = document.getElementById("cpuThreads").value;
        var cpuClock = document.getElementById("cpuClock").value;
        var cpuSocket = document.getElementById("cpuSocket");
        var cpuSocketText = cpuSocket.options[cpuSocket.selectedIndex].value;
        var cpuPrice = document.getElementById("cpuPrice").value;
    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                alert("Response from PHP: " + this.responseText); // Show success or error message
                document.getElementById("addCPUForm").reset(); // Reset form after submission
            }
        };
    
        // Construct GET request without encodeURIComponent()
        xmlhttp.open("GET", "./php/addCPU.php?cpuName=" + cpuName +
                     "&cpuBrand=" + cpuBrandText +
                     "&cpuCores=" + cpuCores +
                     "&cpuThreads=" + cpuThreads +
                     "&cpuClock=" + cpuClock +
                     "&cpuSocket=" + cpuSocketText +
                     "&cpuPrice=" + cpuPrice, true);
        xmlhttp.send();
    });
    

    $('#moboAdd').click(function(){
        validSessionIDCheck();
    
        var form = document.getElementById("addMoboForm"); // Corrected form ID
    
        var moboName = document.getElementById("moboName").value.trim();
        var moboBrand = document.getElementById("moboBrand");
        var moboBrandText = moboBrand.options[moboBrand.selectedIndex].value;
        var moboDdr = document.getElementById("moboDdr").value.trim();
        var moboMemSlots = document.getElementById("moboMemSlots").value.trim();
        var moboM2Slots = document.getElementById("moboMemM2Slots").value.trim();
        var moboChipset = document.getElementById("moboChipset").value.trim();
        var moboPrice = document.getElementById("moboPrice").value.trim();
    
        if (moboName === "" || moboBrandText === "" || moboDdr === "" || moboMemSlots === "" || 
            moboM2Slots === "" || moboChipset === "" || moboPrice === "") {
            alert("All fields are required.");
            return;
        }
    
        var formData = new FormData();
        formData.append("name", moboName);
        formData.append("brand", moboBrandText);
        formData.append("ddr", moboDdr);
        formData.append("memSlots", moboMemSlots);
        formData.append("m2slots", moboM2Slots);
        formData.append("cpuSocket", moboChipset);
        formData.append("price", moboPrice);
    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                try {
                    var response = JSON.parse(this.responseText);
                    if (response.success) {
                        alert(response.success);
                        document.getElementById("addMoboForm").reset();
                    } else {
                        alert(response.error);
                    }
                } catch (e) {
                    alert("Unexpected response from the server.");
                }
            }
        };
    
        xmlhttp.open("POST", "./php/addMobo.php", true);
        xmlhttp.send(formData);
    });
    
    
    


});