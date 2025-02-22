var cpuPrice = 0;
var moboPrice = 0;
var memPrice = 0;
var totalPrice = 0;
var socketID;
var memSlots;
var memQty;
var ddrVersion;

let peso = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'PHP',
});



//DOn'T MIND THIS FIRST ATTEMPT
function cpuShowQueryReturn(cpuName, cpuDesc){
    $('#cpuProdName').text(cpuName);
    $('#cpuDesc').text(cpuDesc);

    $('#cpuProdName').show();
    $('#cpuDesc').show();

}
function cpuRemoveQueryReturn(){
    $('#cpuProdName').text("");
    $('#cpuProdName').hide();
    $('#cpuDesc').hide();
}

function cpuQueryReplaceInput() {
    $('#cpuDataList').hide();
    $('#cpuLoading').show();

    var brand = document.getElementById("cpuBrand");
    var name = document.getElementById("cpuName");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText); // Expecting JSON { "description": "...", "socketID": "..." }
            cpuShowQueryReturn(
                brand.options[brand.selectedIndex].text + " " + name.options[name.selectedIndex].text + " - " + peso.format(cpuPrice),
                response.description
            );
            socketID = response.socketID;  // Store the CPU's socketID
            populateMobo(); // Refresh motherboard selection based on new socketID
        }
    };

    xmlhttp.open("GET", "./php/cpuAdd.php?name=" + name.options[name.selectedIndex].text, false);
    xmlhttp.send();

    $('#cpuLoading').hide();
    $('#addCpuButton').hide();
    $('#remCpuButton').show();
}


function cpuQueryReplaceText() {

    $('#cpuDataList').show();
    $('#cpuDesc').hide(); // Replace input with text

    cpuRemoveQueryReturn();

    $('#remCpuButton').hide();
    $('#addCpuButton').show();

}

function unlockMoboMemory(){
    $('#moboWarning').hide();
    $('#moboDataList').show();
    $('#addMoboButton').show();
}

function lockMoboMemory(){
    $('#moboWarning').show();
    $('#moboDataList').hide();
    $('#addMoboButton').hide();
    $('#remMoboButton').hide();
    removeQueryReturn('#moboProdName', '#moboDesc');
}

function unlockMemory(){
    $('#memWarning').hide();
    $('#memDataList').show();
    $('#addMemButton').show();
}

function lockMemory(){
    $('#memWarning').show();
    $('#memDataList').hide();
    $('#addMemButton').hide();
    $('#remMemButton').hide();
    removeQueryReturn('#memProdName', '#memDesc');
}


//Try to copy this for everything
function populateCPU(){

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){

            if (this.readyState == 4 && this.status == 200) {
                
                document.getElementById("cpuBrand").innerHTML = this.responseText;
            }
        };

        xmlhttp.open("GET", "./php/cpuInitBrand.php", true);
        xmlhttp.send();
        var xmlhttp2 = new XMLHttpRequest();
        xmlhttp2.onreadystatechange = function(){
    
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cpuCores").innerHTML = this.responseText;
            }
        };
        xmlhttp2.open("GET", "./php/cpuInitCores.php", true);
        xmlhttp2.send();
}

function populateMobo() {
    // Populate motherboard brands
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){

        if (this.readyState == 4 && this.status == 200) {
                
            document.getElementById("moboBrand").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "./php/moboInitBrand.php", true);
    xmlhttp.send();

    // Populate motherboard chipsets
    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("moboChip").innerHTML = this.responseText;
        }
    };
    xmlhttp2.open("GET", "./php/moboInitChip.php?socketID=" + socketID, true);
    xmlhttp2.send();
}

function populateMem(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){

        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("memBrand").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/memInitBrand.php", true);
    xmlhttp.send();
    
    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function(){

        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("memSize").innerHTML = this.responseText;
        }
    };
    xmlhttp2.open("GET", "./php/memInitSize.php", true);
    xmlhttp2.send();

    var xmlhttp3 = new XMLHttpRequest();
    xmlhttp3.onreadystatechange = function(){

        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("memQty").innerHTML = this.responseText;
        }
    };

    xmlhttp3.open("GET", "./php/memInitQty.php?memSlots=" + memSlots, true);
    xmlhttp3.send();
    
}

function cpuPriceGet(){

    var name = document.getElementById("cpuName");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            cpuPrice =  this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/cpuPrice.php?name=" + name.options[name.selectedIndex].text, false);
    xmlhttp.send();

    cpuPrice = parseFloat(cpuPrice);


}

function moboPriceGet(){

    var moboChip = document.getElementById("moboChip");
    var moboBrand = document.getElementById("moboBrand");
    var moboName = document.getElementById("moboName");
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            moboPrice =  this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/moboPrice.php?brand=" + moboBrand.options[moboBrand.selectedIndex].text + 
                                            "&chipset=" + moboChip.options[moboChip.selectedIndex].text +
                                            "&name=" + moboName.options[moboName.selectedIndex].text, false);
    xmlhttp.send();

    moboPrice = parseFloat(moboPrice);
}

function memPriceGet(){

    var memBrand = document.getElementById("memBrand");
    var memSize = document.getElementById("memSize");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            memPrice =  this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/memPrice.php?brand=" + memBrand.options[memBrand.selectedIndex].text + 
                                            "&size=" + memSize.options[memSize.selectedIndex].text, false);
    xmlhttp.send();
    
    var memQtyElement = document.getElementById("memQty");
    memQty = parseInt(memQtyElement.options[memQtyElement.selectedIndex].value, 10);
    memPrice = parseFloat(memPrice) * memQty;
}

function hideAtStart(){
    //cpu card hide
    $('#remCpuButton').hide();
    $('#cpuLoading').hide();
    $('#cpuProdName').hide();
    $('#cpuDesc').hide();
    //mobo card hide
    $('#remMoboButton').hide();
    $('#moboLoading').hide();
    $('#moboDataList').hide();
    $('#addMoboButton').hide();
    //memory card hide
    $('#remMemButton').hide();
    $('#memLoading').hide();
    $('#memDataList').hide();
    $('#addMemButton').hide();
    //storage card hide
    

}

function moboShowQueryReturn(moboName, moboDesc){
    $('#moboProdName').text(moboName);
    $('#moboDesc').text(moboDesc);

    $('#moboProdName').show();
    $('#moboDesc').show();
}

function showQueryReturn(itemProdName, itemProdDesc, newItemProdName, newItemProdDesc){
    $(itemProdName).text(newItemProdName);
    $(itemProdDesc).text(newItemProdDesc);

    $(itemProdName).show();
    $(itemProdDesc).show();

}

// Hides the searching function and shows the FULL Name of the the item
// as well as the description
// TODO: IMPLEMENT QUERY HERE

function moboQueryReplaceInput() {
    
    $('#moboDataList').hide(); 
    $('#moboLoading').show();  
    
    var moboBrand = document.getElementById("moboBrand");
    var moboChip = document.getElementById("moboChip");
    var moboName = document.getElementById("moboName");
    var moboFullName = moboBrand.options[moboBrand.selectedIndex].text + " " +
                       moboChip.options[moboChip.selectedIndex].text + " " +
                       moboName.options[moboName.selectedIndex].text;
    var xmlhttp = new XMLHttpRequest();

    // Handle response
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText); // Expecting JSON { "moboname": "...", "description": "..." }
            
            // Update UI with motherboard details
            moboShowQueryReturn(
                moboFullName + " - " + peso.format(moboPrice),
                response.description
            );
            ddrVersion = response.ddrVersion;
            memSlots = response.memSlots;
            populateMem();
        }
    };

    xmlhttp.open("GET", "./php/moboAdd.php?brand=" +  moboBrand.options[moboBrand.selectedIndex].text + 
                                        "&chipset=" + moboChip.options[moboChip.selectedIndex].text +
                                        "&name=" + moboName.options[moboName.selectedIndex].text, false);
    xmlhttp.send();
    $('#moboLoading').hide();
    $('#addMoboButton').hide();
    $('#remMoboButton').show();
}


function moboRemoveQueryReturn(){
    $('#moboProdName').text("");
    $('#moboProdName').hide();
    $('#moboDesc').hide();
}

function moboQueryReplaceText() {

    $('#moboDataList').show();
    $('#moboDesc').hide(); // Replace input with text

    moboRemoveQueryReturn();

    $('#remMoboButton').hide();
    $('#addMoboButton').show();

}

function memQueryReplaceInput() {
    
    $('#memDataList').hide(); 
    $('#memLoading').show();  
    
    var memBrand = document.getElementById("memBrand");
    var memSize =  document.getElementById("memSize");
    var memQtyElement = document.getElementById("memQty");
    memQty = memQtyElement.options[memQtyElement.selectedIndex].text;

    var memFullName = memBrand.options[memBrand.selectedIndex].text + " " +
                      memSize.options[memSize.selectedIndex].text + "x" +
                      memQty;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            
            memShowQueryReturn(
                memFullName + " - " + peso.format(memPrice),
                response.description
            );
        }
    };

    xmlhttp.open("GET", "./php/memAdd.php?brand=" +  memBrand.options[memBrand.selectedIndex].text + 
                                        "&size=" + memSize.options[memSize.selectedIndex].text ,false);
    xmlhttp.send();
    $('#memLoading').hide();
    $('#addMemButton').hide();
    $('#remMemButton').show();
}

function memShowQueryReturn(memName, memDesc){
    $('#memProdName').text(memName);
    $('#memDesc').text(memDesc);

    $('#memProdName').show();
    $('#memDesc').show();
}

function memRemoveQueryReturn(){
    $('#memProdName').text("");
    $('#memProdName').hide();
    $('#memDesc').hide();
}

function memQueryReplaceText() {

    $('#memDataList').show();
    $('#memDesc').hide(); // Replace input with text

    memRemoveQueryReturn();

    $('#addMemButton').hide();
    $('#remMemButton').show();

}

function queryReplaceText(cardDataList, cardLoading, addButton, remButton, itemProdName, itemProdDesc) {
    
    $(cardDataList).show();
    $(itemProdDesc).hide();
    $(itemProdName).hide(); // Replace input with text

    removeQueryReturn(itemProdName, itemProdDesc);

    $(remButton).hide();
    $(addButton).show();

}

function removeQueryReturn(itemProdName, itemProdDesc){
    $(itemProdName).text("");
    $(itemProdDesc).text("");
    $(itemProdName).hide();
    $(itemProdDesc).hide();
}

$(document).ready(function(){
    
    hideAtStart();
    populateCPU();
    populateMobo();
    populateMem();

    //don't use these or try to replicate it, this shit suckss
    $('#addCpuButton').click(function(){
        cpuPriceGet();
        cpuQueryReplaceInput();
        unlockMoboMemory();
        totalPrice += cpuPrice;

        document.getElementById("cpuPriceList").innerText = "CPU: " +  peso.format(cpuPrice);
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });

    $('#remCpuButton').click(function(){
        cpuQueryReplaceText();
        lockMoboMemory();
        lockMemory();
        totalPrice -= cpuPrice;
        cpuPrice = 0;
        document.getElementById("cpuPriceList").innerText = "";
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });    

    $('#cpuSearch').click(function(){
        
        var cpuBrand = document.getElementById("cpuBrand");
        
        var cpuBrandText = cpuBrand.options[cpuBrand.selectedIndex].value;
        var cpuCores = document.getElementById("cpuCores");

        var cpuCoresText = cpuCores.options[cpuCores.selectedIndex].value;
        document.getElementById("cpuName").removeAttribute("disabled");


        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cpuName").innerHTML = this.responseText;                
            }
        };
        
        xmlhttp.open("GET", "./php/cpuSearch.php?brand=" + cpuBrandText + "&cores=" + cpuCoresText , true);
        xmlhttp.send();


    })

    $('#addMoboButton').click(function() {

        moboPriceGet(); // Fetch motherboard price
        moboQueryReplaceInput();
        unlockMemory();
    
        totalPrice += moboPrice;
        document.getElementById("moboPriceList").innerText = "Motherboard: " + peso.format(moboPrice);
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });
    
    $('#remMoboButton').click(function() {
        moboQueryReplaceText(); 
        lockMemory();
    
        totalPrice -= moboPrice;
        moboPrice = 0;
        document.getElementById("moboPriceList").innerText = "";
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });

    $('#moboSearch').click(function(){


        var moboBrand = document.getElementById("moboBrand");
        
        var moboBrandText = moboBrand.options[moboBrand.selectedIndex].value;
        var moboChip = document.getElementById("moboChip");

        var moboChipText = moboChip.options[moboChip.selectedIndex].value;
        document.getElementById("moboName").removeAttribute("disabled");
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("moboName").innerHTML = this.responseText;                
            }
        };
        
        xmlhttp.open("GET", "./php/moboSearch.php?brand=" + moboBrandText + "&chipset=" + moboChipText , true);
        xmlhttp.send();

    })

    $('#addMemButton').click(function() {

        memPriceGet();
        memQueryReplaceInput();

        totalPrice += memPrice;
        document.getElementById("memPriceList").innerText = "Memory: " + peso.format(memPrice);
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });

    $('#remMemButton').click(function() {
        memQueryReplaceText(); 
    
        totalPrice -= memPrice;
        memPrice = 0;
        document.getElementById("memPriceList").innerText = "";
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });

    $('#memSearch').click(function(){
        var memBrand = document.getElementById("memBrand");
        
        var memBrandText = memBrand.options[memBrand.selectedIndex].value;
        var memSize = document.getElementById("memSize");

        var memSizeText = memSize.options[memSize.selectedIndex].value;
        document.getElementById("memName").removeAttribute("disabled");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("memName").innerHTML = this.responseText;                
            }
        };
 
        xmlhttp.open("GET", "./php/memSearch.php?brand=" + memBrandText + "&size=" + memSizeText , true);
        xmlhttp.send();

    })
});