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

function getSockets(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {
            
            document.getElementById("cpuSocket").innerHTML = this.responseText;
            document.getElementById("moboSocket").innerHTML = this.responseText;
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

function delBuild(buildNumber){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {

        }
    };

    xmlhttp.open("GET", "./php/deleteBuild.php?id=" + buildNumber, true);
    xmlhttp.send();
    location.reload();
}


function popBuilds(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("manBuild").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/getBuilds.php", true);
    xmlhttp.send();

}

$(document).ready(function(){

    validSessionIDCheck();
    populateCPU();
    getSockets();
    popMem();
    popBuilds();


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
    

    document.getElementById("moboAdd").addEventListener("click", function() {
        var form = document.getElementById("addMoboForm");
    
        var moboName = document.getElementById("moboName").value
        var moboSocketId = document.getElementById("moboSocket").value;
        var moboBrand = document.getElementById("moboBrand");
        var moboBrandText = moboBrand.options[moboBrand.selectedIndex].value;
        var moboDdr = document.getElementById("moboDDR").value
        var moboMemSlots = document.getElementById("moboMemSlots").value
        var moboM2Slots = document.getElementById("moboM2Slots").value
        var moboChipset = document.getElementById("moboChipset").value
        var moboPrice = document.getElementById("moboPrice").value

        if (moboName === "" || moboSocketId === "" || moboBrandText === "" || moboDdr === "" || moboMemSlots === "" || 
            moboM2Slots === "" || moboChipset === "" || moboPrice === "") {
            alert("All fields are required.");
            return;
        }
    
        var formData = new FormData(form);
    
        formData.append("name", moboName);
        formData.append("socketId", moboSocketId);
        formData.append("brand", moboBrandText);
        formData.append("ddr", moboDdr);
        formData.append("memSlots", moboMemSlots);
        formData.append("m2slots", moboM2Slots);
        formData.append("chipset", moboChipset);
        formData.append("price", moboPrice);

        fetch("./php/addMobo.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Motherboard added successfully!");
                form.reset();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Something went wrong. Please try again.");
        });
    });
    
    document.getElementById("memAdd").addEventListener("click", function() {
        var form = document.getElementById("addMemForm");
    
        var memBrand = document.getElementById("memBrand");
        var memBrandText = memBrand.options[memBrand.selectedIndex].value;
        var memDdr = document.getElementById("memDDR").value;
        var memSize = document.getElementById("memSize").value;
        var memPrice = document.getElementById("memPrice").value;

        if (memBrandText === "" || memDdr === "" || memSize === "" || memPrice === "") {
            alert("All fields are required.");
            return;
        }
    
        var formData = new FormData(form);
    
        formData.append("brand", memBrandText);
        formData.append("ddr", memDdr);
        formData.append("size", memSize);
        formData.append("price", memPrice);
    
        fetch("./php/addMem.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Memory added successfully!");
                form.reset();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Something went wrong. Please try again.");
        });
    });
    
});