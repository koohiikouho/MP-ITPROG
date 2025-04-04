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
            document.getElementById("vendorSelect").innerHTML = fillAll;
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
    var element = document.getElementById("trbld" + buildNumber);
    element.parentNode.removeChild(element);
}


function delCases(buildNumber){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {

        }
    };

    xmlhttp.open("GET", "./php/deleteCases.php?id=" + buildNumber, true);
    xmlhttp.send();
    var element = document.getElementById("trcse" + buildNumber);
    element.parentNode.removeChild(element);
}

function delPSUs(buildNumber){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {

        }
    };

    xmlhttp.open("GET", "./php/deletePSUs.php?id=" + buildNumber, true);
    xmlhttp.send();
    var element = document.getElementById("trpsu" + buildNumber);
    element.parentNode.removeChild(element);
}

function delStorage(buildNumber){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {

        }
    };

    xmlhttp.open("GET", "./php/deleteStorage.php?id=" + buildNumber, true);
    xmlhttp.send();
    var element = document.getElementById("trsto" + buildNumber);
    element.parentNode.removeChild(element);
}

function delMemory(buildNumber){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {

        }
    };

    xmlhttp.open("GET", "./php/deleteMemory.php?id=" + buildNumber, true);
    xmlhttp.send();
    var element = document.getElementById("trmem" + buildNumber);
    element.parentNode.removeChild(element);
}

function delMobo(buildNumber){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {

        }
    };

    xmlhttp.open("GET", "./php/deleteMotherboard.php?id=" + buildNumber, true);
    xmlhttp.send();
    var element = document.getElementById("trmob" + buildNumber);
    element.parentNode.removeChild(element);
}

function delCPUs(buildNumber){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {

        }
    };

    xmlhttp.open("GET", "./php/deleteCPUs.php?id=" + buildNumber, true);
    xmlhttp.send();
    var element = document.getElementById("trcpu" + buildNumber);
    element.parentNode.removeChild(element);
}

function delGPUs(buildNumber){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {

        }
    };

    xmlhttp.open("GET", "./php/deleteGPUs.php?id=" + buildNumber, true);
    xmlhttp.send();
    var element = document.getElementById("trgpu" + buildNumber);
    element.parentNode.removeChild(element);
}


function getCases(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updCase").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/getCases.php", true);
    xmlhttp.send();
}

function getPSUs(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updPSU").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/getPSUs.php", true);
    xmlhttp.send();
}


function getGPUs(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updGPU").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/getGPUs.php", true);
    xmlhttp.send();

}


function getStorage(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updStorage").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/getStorage.php", true);
    xmlhttp.send();

}

function getCPUs() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updCPU").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/getCPUs.php", true);
    xmlhttp.send();

}

function getMobo(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updMotherboard").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/getMobo.php", true);
    xmlhttp.send();

}

function getMem(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updMemory").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/getMem.php", true);
    xmlhttp.send();

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

function moboFill(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("manBuild").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "./php/getBuilds.php", true);
    xmlhttp.send();
}
function populateMotherboard(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mobUpdateList").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "./php/updateComponent/mobo/popMobo.php", true);
    xmlhttp.send();
}

function populateMemory(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("memUpdateList").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "./php/updateComponent/memory/popMem.php", true);
    xmlhttp.send();
}

function populateStorage(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("stoUpdateList").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "./php/updateComponent/storage/popSto.php", true);
    xmlhttp.send();
}

function populateCase(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("caseUpdateList").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "./php/updateComponent/case/popCase.php", true);
    xmlhttp.send();
}

function helpCase(value){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updCaseForm").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","./php/updateComponent/case/helpCase.php?cse_id=" + value, true);
    xmlhttp.send();
}

function helpMobo(value){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updMoboForm").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","./php/updateComponent/mobo/helpMobo.php?mobo_id=" + value, true);
    xmlhttp.send();
}

function helpMem(value){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updMemForm").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","./php/updateComponent/memory/helpMem.php?mem_id=" + value, true);
    xmlhttp.send();
}

function helpSto(value){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updStoForm").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","./php/updateComponent/storage/helpSto.php?sto_id=" + value, true);
    xmlhttp.send();

}

function helpCPU(value){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updCPUForm").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","./php/updateComponent/cpu/helpCPU.php?cpu_id=" + value, true);
    xmlhttp.send();
}

function helpPSU(value){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updPSUForm").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","./php/updateComponent/psu/helpPSU.php?psu_id=" + value, true);
    xmlhttp.send();
}

function helpGPU(value){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("updGPUForm").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","./php/updateComponent/gpu/helpGPU.php?gpu_id=" + value, true);
    xmlhttp.send();
}


$(document).ready(function(){

    validSessionIDCheck();
    getSockets();
    popMem();
    popBuilds();
    populateCPU();
    populateMotherboard();
    populateMemory();
    populateStorage();
    populateCase();
    getCPUs();
    getCases();
    getPSUs();
    getStorage();
    getGPUs();
    getMobo();
    getMem();


    $('#searchCase').click(function(){


    });
    
    document.getElementById("generateReportBtn").addEventListener("click", function () {
        fetch("./php/popularityReport.php", {
            method: "POST",
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                document.getElementById("reportContainer").innerHTML = data.html;
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Something went wrong. Please try again.");
        });
    });
    

    document.getElementById("cpuAdd").addEventListener("click", function(e) {
        e.preventDefault();
        var form = document.getElementById("addCPUForm");
    
        var cpuName = document.getElementById("cpuName").value;
        var cpuBrand = document.getElementById("cpuBrand");
        var cpuBrandText = cpuBrand.options[cpuBrand.selectedIndex].value;
        var cpuCores = document.getElementById("cpuCores").value;
        var cpuThreads = document.getElementById("cpuThreads").value;
        var cpuClock = document.getElementById("cpuClock").value;
        var cpuSocket = document.getElementById("cpuSocket");
        var cpuSocketText = cpuSocket.options[cpuSocket.selectedIndex].value;
        var cpuPrice = document.getElementById("cpuPrice").value;
    
        var formData = new FormData(form);
        
        formData.append("cpuName", cpuName);
        formData.append("cpuBrand", cpuBrandText);
        formData.append("cpuCores", cpuCores);
        formData.append("cpuThreads", cpuThreads);
        formData.append("cpuClock", cpuClock);
        formData.append("cpuSocket", cpuSocketText);
        formData.append("cpuPrice", cpuPrice);
    
        fetch("./php/addCPU.php", {
            method: "POST",
            body: formData,
        })
        .then(() => {
            alert("CPU has been added successfully!");
            form.reset();
        })
        .catch(() => alert("Something went wrong. Please try again."));
    });

    document.getElementById("moboAdd").addEventListener("click", function(e) {
        e.preventDefault();
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
        .then(() => {
            alert("Motherboard has been added successfully!");
            form.reset();
        })
        .catch(() => alert("Something went wrong. Please try again."));
    });
    
    document.getElementById("memAdd").addEventListener("click", function(e) {
        e.preventDefault();
        var form = document.getElementById("addMemForm");
    
        var memBrand = document.getElementById("memBrand");
        var memBrandText = memBrand.options[memBrand.selectedIndex].value;
        var memDdr = document.getElementById("memDDR").value;
        var memSize = document.getElementById("memSize").value;
        var memPrice = document.getElementById("memPrice").value;
    
        var formData = new FormData(form);
    
        formData.append("brand", memBrandText);
        formData.append("ddr", memDdr);
        formData.append("size", memSize);
        formData.append("price", memPrice);
    
        fetch("./php/addMem.php", {
            method: "POST",
            body: formData,
        })
        .then(() => {
            alert("Memory has been added successfully!");
            form.reset();
        })
        .catch(() => alert("Something went wrong. Please try again."));
    });
    
    document.getElementById("stoAdd").addEventListener("click", function(e) {
        e.preventDefault();
        var form = document.getElementById("addStoForm");
    
        var stoBrand = document.getElementById("stoBrand");
        var stoBrandText = stoBrand.options[stoBrand.selectedIndex].value;
        var stoSize = document.getElementById("stoSize").value;
        var stoType = document.getElementById("stoType").value;
        var stoConn = document.getElementById("stoConn").value;
        var stoPrice = document.getElementById("stoPrice").value;

        var formData = new FormData(form);
    
        formData.append("brand", stoBrandText);
        formData.append("size", stoSize);
        formData.append("type", stoType);
        formData.append("connection", stoConn);
        formData.append("price", stoPrice);
    
        fetch("./php/addSto.php", {
            method: "POST",
            body: formData,
        })
        .then(() => {
            alert("Storage has been added successfully!");
            form.reset();
        })
        .catch(() => alert("Something went wrong. Please try again."));
    });
    
    document.getElementById("caseAdd").addEventListener("click", function(e) {
        e.preventDefault();
        var form = document.getElementById("addCaseForm");
    
        var caseBrand = document.getElementById("caseBrand");
        var caseBrandText = caseBrand.options[caseBrand.selectedIndex].value;
        var caseName = document.getElementById("caseName").value;
        var casePrice = document.getElementById("casePrice").value;
        
        var formData = new FormData(form);
    
        formData.append("brand", caseBrandText);
        formData.append("name", caseName);
        formData.append("price", casePrice);
    
        fetch("./php/addCase.php", {
            method: "POST",
            body: formData,
        })
        .then(() => {
            alert("Case has been added successfully!");
            form.reset();
        })
        .catch(() => alert("Something went wrong. Please try again."));
    });
    
    document.getElementById("psuAdd").addEventListener("click", function(e) {
        e.preventDefault();
        var form = document.getElementById("addPSUForm");
    
        var psuBrand = document.getElementById("psuBrand");
        var psuBrandText = psuBrand.options[psuBrand.selectedIndex].value;
        var psuWattage = document.getElementById("psuWattage").value;
        var psuEfficiency = document.getElementById("psuEfficiency").value;
        var psuPrice = document.getElementById("psuPrice").value;

        var formData = new FormData(form);
    
        formData.append("brand", psuBrandText);
        formData.append("wattage", psuWattage);
        formData.append("efficiency", psuEfficiency);
        formData.append("price", psuPrice);
    
        fetch("./php/addPSU.php", {
            method: "POST",
            body: formData,
        })
        .then(() => {
            alert("PSU has been added successfully!");
            form.reset();
        })
        .catch(() => alert("Something went wrong. Please try again."));
    });

    document.getElementById("gpuAdd").addEventListener("click", function(e) {
        e.preventDefault();
        var form = document.getElementById("addGPUForm");
    
        var gpuBrand = document.getElementById("gpuBrand");
        var gpuBrandText = gpuBrand.options[gpuBrand.selectedIndex].value;
        var gpuVendor = document.getElementById("gpuVendor");
        var gpuVendorText = gpuVendor.options[gpuVendor.selectedIndex].value;
        var gpuName = document.getElementById("gpuModel").value;
        var gpuPrice = document.getElementById("gpuPrice").value;

        var formData = new FormData(form);
    
        formData.append("brand", gpuBrandText);
        formData.append("vendor", gpuVendorText);
        formData.append("name", gpuName);
        formData.append("price", gpuPrice);
    
        fetch("./php/addGPU.php/", {
            method: "POST",
            body: formData,
        })
        .then(() => {
            alert("GPU has been added successfully!");
            form.reset();
        })
        .catch(() => alert("Something went wrong. Please try again."));

    });
    

});