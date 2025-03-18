var cpuPrice = 0.00;
var moboPrice = 0.00;
var memPrice = 0.00;
var stoPrice = 0.00;
var casePrice = 0.00;
var psuPrice = 0.00;
var gpuPrice = 0.00;
var totalPrice = 0.00;
var socketID;
var memSlots;
var memQty;
var ddrVersion;
var m2Slots;

let peso = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'PHP',
});

document.addEventListener("DOMContentLoaded", function () {
        
    const categorySelect = document.getElementById("componentCategory");
    const updateSelect = document.getElementById("updateComponentCategory");

    const extraFields = document.getElementById("extraFields");
    const extraFields2 = document.getElementById("extraFields2");

    categorySelect.addEventListener("change", function () {
        updateExtraFields(categorySelect.value, extraFields);
    });
    
    updateSelect.addEventListener("change", function () {
        updateExtraFields(updateSelect.value, extraFields2);
    });

    function updateExtraFields(category, container) {
        container.innerHTML = ""; // Clear existing fields

        let fieldHTML = "";
        if (category === "CPU") {
            fieldHTML = `
                <div class="mb-3">
                    <label class="form-label">Cores</label>
                    <input type="number" class="form-control" id="cpuCores" required>
                </div>
            `;
        } else if (category === "GPU") {
            fieldHTML = `
                <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <input type="text" class="form-control" id="gpuBrand" required>
                </div>
            `;
        } else if (category === "Memory") {
            fieldHTML = `
                <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <input type="text" class="form-control" id="memBrand" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Size</label>
                    <input type="number" class="form-control" id="memSize" required>
                </div>
            `;
        } else if (category === "Storage") {
            fieldHTML = `
                <div class="mb-3">
                    <label class="form-label">Storage Type</label>
                    <input type="text" class="form-control" id="storageType" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Size</label>
                    <input type="number" class="form-control" id="storageCapacity" required>
                </div>
            `;
        } else if (category === "PSU") {
            fieldHTML = `
                <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <input type="text" class="form-control" id="psuBrand" required>
                </div>
            `;
        } else if (category === "Motherboard") {
            fieldHTML = `
                <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <input type="text" class="form-control" id="moboBrand" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Chipset</label>
                    <input type="text" class="form-control" id="moboChipset" required>
                </div>
            `;
        } else if (category === "Case") {
            fieldHTML = `
                <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <input type="text" class="form-control" id="caseBrand" required>
                </div>
            `;
        }

        
        container.innerHTML = fieldHTML;
    }

    updateExtraFields(categorySelect.value, extraFields);
    updateExtraFields(updateSelect.value, extraFields2);
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

            var cpuSort = document.getElementById("cpuSort");
            var cpuSortText = cpuSort.options[cpuSort.selectedIndex].id;

            // No need to concat price to display
            if (cpuSortText == "price") {
                cpuShowQueryReturn(
                    brand.options[brand.selectedIndex].text + " " + name.options[name.selectedIndex].text,
                    response.description
                );
            } else if (cpuSortText == "popularity") {
                cpuShowQueryReturn(
                    brand.options[brand.selectedIndex].text + 
                    " " + name.options[name.selectedIndex].text + 
                    " - " + peso.format(cpuPrice),
                    response.description
                );
            }
        
            socketID = response.socketID;  // Store the CPU's socketID
            populateMobo(); // Refresh motherboard selection based on new socketID
        }
    };

    xmlhttp.open("GET", "./php/cpuAdd.php?name=" + name.options[name.selectedIndex].value, false);
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
    removeQueryReturn('#memProdName', '#memProdDesc');
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

function populateSto() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){

        if (this.readyState == 4 && this.status == 200) {
                
            document.getElementById("stoBrand").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "./php/stoInitBrand.php", true);
    xmlhttp.send();

    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("stoType").innerHTML = this.responseText;
        }
    };
    xmlhttp2.open("GET", "./php/stoInitType.php?m2Slots=" + m2Slots, true);
    xmlhttp2.send();
}

function populateCase() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){

        if (this.readyState == 4 && this.status == 200) {
                
            document.getElementById("caseBrand").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "./php/caseInitBrand.php", true);
    xmlhttp.send();
}

function populatePSU(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){

        if (this.readyState == 4 && this.status == 200) {
            
            document.getElementById("psuBrand").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/psuInitBrand.php", true);
    xmlhttp.send();
}

function populateGPU(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){

        if (this.readyState == 4 && this.status == 200) {
            
            document.getElementById("gpuBrand").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/gpuInitBrand.php", true);
    xmlhttp.send();
}

function cpuPriceGet(){

    var name = document.getElementById("cpuName");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            tempPrice = this.responseText;
            if(tempPrice != "Error")            
                cpuPrice = tempPrice;
                
        }
    };

    xmlhttp.open("GET", "./php/cpuPrice.php?id=" + name.options[name.selectedIndex].value, false);
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
            tempPrice = this.responseText;
            if(tempPrice != "Error")
                moboPrice =  tempPrice;
        }
    };

    xmlhttp.open("GET", "./php/moboPrice.php?brand=" + moboBrand.options[moboBrand.selectedIndex].text + 
                                            "&chipset=" + moboChip.options[moboChip.selectedIndex].text +
                                            "&mob_id=" + moboName.options[moboName.selectedIndex].value, false);
    xmlhttp.send();

    moboPrice = parseFloat(moboPrice);
}

function memPriceGet(){

    var memBrand = document.getElementById("memBrand");
    var memSize = document.getElementById("memSize");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            tempPrice = this.responseText;
            if(tempPrice != "Error")   
                memPrice =  tempPrice;
        }
    };

    xmlhttp.open("GET", "./php/memPrice.php?brand=" + memBrand.options[memBrand.selectedIndex].text + 
                                            "&size=" + memSize.options[memSize.selectedIndex].text, false);
    xmlhttp.send();
    
    var memQtyElement = document.getElementById("memQty");
    memQty = parseInt(memQtyElement.options[memQtyElement.selectedIndex].value, 10);
    memPrice = parseFloat(memPrice) * memQty;
}

function stoPriceGet(){
    var stoID = document.getElementById("stoSize");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            tempPrice = this.responseText;
            if(parseFloat(tempPrice) > 0)   
                stoPrice =  tempPrice;
        }
    };


    xmlhttp.open("GET", "./php/stoPrice.php?id=" + stoSize.options[stoSize.selectedIndex].value, false);
    xmlhttp.send();

    stoPrice = parseFloat(stoPrice);
}

function casePriceGet(){

    var caseName = document.getElementById("caseName");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            tempPrice = this.responseText;
            if(tempPrice != "Error")   
                casePrice =  tempPrice;
        }
    };

    xmlhttp.open("GET", "./php/casePrice.php?id=" + caseName.value , false);
    xmlhttp.send();
    casePrice = parseFloat(casePrice);
}

function psuPriceGet(){

    var id = document.getElementById("psuName");
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            tempPrice = this.responseText;
            if(tempPrice != "Error")   
                psuPrice =  tempPrice;
        }
    };

    xmlhttp.open("GET", "./php/psuPrice.php?id=" + id.value, false);
    xmlhttp.send();

    psuPrice = parseFloat(psuPrice);
}

function gpuPriceGet(){
    var id = document.getElementById("gpuName");
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            tempPrice = this.responseText;
            if(tempPrice != "Error")   
                gpuPrice =  tempPrice;
        }
    };

    xmlhttp.open("GET", "./php/gpuPrice.php?id=" + id.value, false);
    xmlhttp.send();
    
        gpuPrice = parseFloat(gpuPrice);
        
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
    $('#remStoButton').hide();
    $('#stoProdName').hide();
    $('#stoProdDesc').hide();
    $('#stoLoading').hide();
    
    $('#remCaseButton').hide();
    $('#remPsuButton').hide();

    //storage card hide
    $('#remStoButton').hide();
    $('#Name').hide();

    //case card hide
    $('#caseLoading').hide();
    $('#caseProdName').hide();
    $('#caseProdDesc').hide();


    $('#psuLoading').hide();
    $('#psuProdName').hide();
    $('#psuProdDesc').hide();

    $('#remGpuButton').hide();
    $('#gpuLoading').hide();
    $('#gpuProdName').hide();
    $('#gpuProdDesc').hide();
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

    var moboSort = document.getElementById("moboSort");
    var moboSortText = moboSort.options[moboSort.selectedIndex].id;

    // Handle response
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText); // Expecting JSON { "moboname": "...", "description": "..." }

            // WIP
            if (moboSortText == "price") {
                moboShowQueryReturn(
                    moboFullName,
                    response.description,
                    response.memSlots,
                    response.ddrVersion,
                    response.m2Slots
                );
            } else if (moboSortText == "popularity") {
                moboShowQueryReturn(
                    moboFullName + " - " + peso.format(moboPrice),
                    response.description,
                    response.memSlots,
                    response.ddrVersion,
                    response.m2Slots
                );
            }
            
            memSlots = response.memSlots;
            ddrVersion = response.ddrVersion;
            m2Slots = response.m2Slots;

            populateMem();
        }
    };

    xmlhttp.open("GET", "./php/moboAdd.php?mob_id=" +  moboName.options[moboName.selectedIndex].value, false);
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
    
    var memName = document.getElementById("memName");
    var memQtyElement = document.getElementById("memQty");
    memQty = memQtyElement.options[memQtyElement.selectedIndex].text;

    var memNameText = memQty + "x " + memName.options[memName.selectedIndex].text;
                      
    var memSort = document.getElementById("memSort");
    var memSortText = memSort.options[memSort.selectedIndex].id;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);

            if (memSortText == "price") {
                memShowQueryReturn(
                    memNameText,
                    response.description
                );
            } else if (memSortText == "popularity") {
                memShowQueryReturn(
                    memNameText + " - " + peso.format(memPrice),
                    response.description
                );
            }
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
    $('#memProdDesc').text(memDesc);

    $('#memProdName').show();
    $('#memProdDesc').show();
}

function memRemoveQueryReturn(){
    $('#memProdName').text("");
    $('#memProdName').hide();
    $('#memProdDesc').hide();
}

function memQueryReplaceText() {

    $('#memDataList').show();
    $('#memProdDesc').hide(); // Replace input with text

    memRemoveQueryReturn();

    $('#addMemButton').show();
    $('#remMemButton').hide();

}

function stoQueryReplaceInput() {
    
    $('#stoDataList').hide(); 
    $('#stoLoading').show(); 
    
    var stoBrand = document.getElementById("stoBrand");
    var stoType = document.getElementById("stoType");
    var stoSize = document.getElementById("stoSize");
    var stoFullName = stoBrand.options[stoBrand.selectedIndex].text + " " +
                       stoSize.options[stoSize.selectedIndex].text + " " +
                       stoType.options[stoType.selectedIndex].text;

    var stoSort = document.getElementById("stoSort");
    var stoSortText = stoSort.options[stoSort.selectedIndex].id;
    
    // No need to concat price to display
    if (stoSortText == "price") {
        stoShowQueryReturn(
            stoFullName
        );
    } else if (stoSortText == "popularity") {
        stoShowQueryReturn(
            stoFullName + " - " + peso.format(stoPrice)
        );
    }
    
    $('#stoProdName').show(); 
    $('#stoProdDesc').show(); 
    $('#stoLoading').hide(); 

    $('#addStoButton').hide();
    $('#remStoButton').show();
}


function stoShowQueryReturn(stoName){
    $('#stoProdName').text(stoName);
    $('#stoProdName').show();
}


function stoRemoveQueryReturn(){
    $('#stoProdName').text("");
    $('#stoProdName').hide();
}

function stoQueryReplaceText() {

    $('#stoDataList').show();

    stoRemoveQueryReturn();

    $('#remStoButton').hide();
    $('#addStoButton').show();

}

function caseQueryReplaceInput() {
    
    $('#caseDataList').hide(); 
    $('#caseLoading').show();  
    
    var caseName = document.getElementById("caseName");
    var caseNameText = caseName.options[caseName.selectedIndex].text;
    var caseSort = document.getElementById("caseSort");
    var caseSortText = caseSort.options[caseSort.selectedIndex].id;
    
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
        
            if (caseSortText == "price") {
                caseShowQueryReturn(
                    caseNameText
                );
            } else if (caseSortText == "popularity") {
                caseShowQueryReturn(
                    caseNameText + " - " + peso.format(casePrice)
                );
            }
        }
    };


    if (caseSortText == "price") {
        caseShowQueryReturn(
            caseNameText
        );
    } else if (caseSortText == "popularity") {
        caseShowQueryReturn(
            caseNameText + " - " + peso.format(casePrice)
        );
    }

    $('#caseLoading').hide();

    $('#caseProdName').show();
    $('#caseProdDesc').show();
    
    $('#addCaseButton').hide();
    $('#remCaseButton').show();
}

function caseShowQueryReturn(caseName){
    $('#caseProdName').text(caseName);

    $('#caseProdName').show();
}

function caseRemoveQueryReturn(){
    $('#caseProdName').text("");
    $('#caseProdName').hide();
    $('#caseDesc').hide();
}

function caseQueryReplaceText() {

    $('#caseDataList').show();
    $('#caseDesc').hide(); // Replace input with text

    caseRemoveQueryReturn();

    $('#remCaseButton').hide();
    $('#addCaseButton').show();

}

function psuQueryReplaceInput() {
    
    $('#psuDataList').hide(); 
    //$('#psuLoading').show();  
    
    var psuName = document.getElementById("psuName");
    var psuNameText = psuName.options[psuName.selectedIndex].text;
    var psuSort = document.getElementById("psuSort");
    var psuSortText = psuSort.options[psuSort.selectedIndex].id;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            
            if (psuSortText == "price") {
                psuShowQueryReturn(
                    psuNameText
                );
            } else if (psuSortText == "popularity") {
                psuShowQueryReturn(
                    psuNameText + " - " + peso.format(psuPrice)
                );
            }
        }
    };

    //$('#psuLoading').hide();
    if (psuSortText == "price") {
        psuShowQueryReturn(
            psuNameText
        );
    } else if (psuSortText == "popularity") {
        psuShowQueryReturn(
            psuNameText + " - " + peso.format(psuPrice)
        );
    }

    $('#addPsuButton').hide();
    $('#remPsuButton').show();
}

function psuShowQueryReturn(psuName){
    $('#psuProdName').text(psuName);

    $('#psuProdName').show();
}

function psuRemoveQueryReturn(){
    $('#psuProdName').text("");
    $('#psuProdName').hide();
}

function psuQueryReplaceText() {

    $('#psuDataList').show();
    psuRemoveQueryReturn();

    $('#remPsuButton').hide();
    $('#addPsuButton').show();

}

function gpuQueryReplaceInput() {
    
    $('#gpuDataList').hide(); 
    $('#gpuLoading').show();

    var gpuName = document.getElementById("gpuName");
    var gpuNameText = gpuName.options[gpuName.selectedIndex].text;
    var gpuSort = document.getElementById("gpuSort");
    var gpuSortText = gpuSort.options[gpuSort.selectedIndex].id;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            
            gpuShowQueryReturn(
                gpuNameText + " - " + peso.format(gpuPrice)
            );
        }
    };

    if (gpuSortText == "price") {
        gpuShowQueryReturn(
            gpuNameText
        );
    } else if (gpuSortText == "popularity") {
        gpuShowQueryReturn(
            gpuNameText + " - " + peso.format(gpuPrice)
        );
    }

    $('#gpuLoading').hide();
    $('#gpuProdName').show();
    $('#gpuProdDesc').show();
    $('#addGpuButton').hide();
    $('#remGpuButton').show();

}

function gpuShowQueryReturn(gpuName){
    $('#gpuProdName').text(gpuName);

    $('#gpuProdName').show();
}

function gpuRemoveQueryReturn(){
    $('#gpuProdName').text("");
    $('#gpuProdName').hide();
}

function gpuQueryReplaceText() {

    $('#gpuDataList').show();
    gpuRemoveQueryReturn();

    $('#remGpuButton').hide();
    $('#addGpuButton').show();

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

function turnNanToFloat(nanvar){
    if(nanvar == NaN)
        nanvar = 0;
}


$(document).ready(function(){
    
    hideAtStart();
    populateCPU();
    populateMobo();
    populateMem();
    populateSto();
    populateCase();
    populatePSU();
    populateGPU();

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

        // Also remove mobo price and memory price
        totalPrice -= moboPrice;
        moboPrice = 0;
        document.getElementById("moboPriceList").innerText = "";
        totalPrice -= memPrice;
        memPrice = 0;
        document.getElementById("memPriceList").innerText = "";

        document.getElementById("cpuPriceList").innerText = "";
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });    

    $('#cpuSearch').click(function(){
        
        var cpuBrand = document.getElementById("cpuBrand");
        var cpuBrandText = cpuBrand.options[cpuBrand.selectedIndex].value;

        var cpuCores = document.getElementById("cpuCores");
        var cpuCoresText = cpuCores.options[cpuCores.selectedIndex].value;
        document.getElementById("cpuName").removeAttribute("disabled");

        var cpuSort = document.getElementById("cpuSort");
        var cpuSortText = cpuSort.options[cpuSort.selectedIndex].id;
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cpuName").innerHTML = this.responseText;                
            }
        };
        
        xmlhttp.open("GET", "./php/cpuSearch.php?brand=" + cpuBrandText + "&cores=" + cpuCoresText + "&sortby=" + cpuSortText, true);
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
        memPrice = 0;
        totalPrice -= memPrice;
        document.getElementById("memPriceList").innerText = "";
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });

    $('#moboSearch').click(function(){


        var moboBrand = document.getElementById("moboBrand");
        
        var moboBrandText = moboBrand.options[moboBrand.selectedIndex].value;
        var moboChip = document.getElementById("moboChip");

        var moboChipText = moboChip.options[moboChip.selectedIndex].value;
        document.getElementById("moboName").removeAttribute("disabled");

        var moboSort = document.getElementById("moboSort");
        var moboSortText = moboSort.options[moboSort.selectedIndex].id;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("moboName").innerHTML = this.responseText;                
            }
        };
        
        xmlhttp.open("GET", "./php/moboSearch.php?brand=" + moboBrandText + "&chipset=" + moboChipText + "&sortby=" + moboSortText, true);
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

        var memSort = document.getElementById("memSort");
        var memSortText = memSort.options[memSort.selectedIndex].id;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("memName").innerHTML = this.responseText;                
            }
        };
        
        xmlhttp.open("GET", "./php/memSearch.php?brand=" + memBrandText + 
                            "&size=" + memSizeText +
                            "&ddrversion=" + ddrVersion + "&sortby=" + memSortText, true);
        xmlhttp.send();

    })

    $('#addStoButton').click(function() {

        stoPriceGet();
        stoQueryReplaceInput();
    
        totalPrice += stoPrice;
        document.getElementById("stoPriceList").innerText = "Storage: " + peso.format(stoPrice);
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);

    });
    
    $('#remStoButton').click(function() {
        stoQueryReplaceText(); 
    
        totalPrice -= stoPrice;
        stoPrice = 0;
        document.getElementById("stoPriceList").innerText = "";
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });


    $('#stoSearch').click(function(){
        var stoBrand = document.getElementById("stoBrand");
        
        var stoBrandText = stoBrand.options[stoBrand.selectedIndex].value;
        var stoType = document.getElementById("stoType");

        var stoSort = document.getElementById("stoSort");
        var stoSortText = stoSort.options[stoSort.selectedIndex].id;
        
        var stoTypeText = stoType.options[stoType.selectedIndex].value;
        document.getElementById("stoSize").removeAttribute("disabled");
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("stoSize").innerHTML = this.responseText;                
            }
        };

        xmlhttp.open("GET", "./php/stoSearch.php?brand=" + stoBrandText + "&type=" + stoTypeText + "&sortby=" + stoSortText, true);
        xmlhttp.send();

    })

    $('#addCaseButton').click(function() {

        casePriceGet();
        caseQueryReplaceInput();

        totalPrice += casePrice;
        document.getElementById("casePriceList").innerText = "Case: " + peso.format(casePrice);
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });

    $('#remCaseButton').click(function() {
        caseQueryReplaceText(); 
    
        totalPrice -= casePrice;
        document.getElementById("casePriceList").innerText = "";
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });

    $('#caseSearch').click(function(){
        var caseBrand = document.getElementById("caseBrand");
        var caseBrandText = caseBrand.options[caseBrand.selectedIndex].value;
        
        var caseSort = document.getElementById("caseSort");
        var caseSortText = caseSort.options[caseSort.selectedIndex].id;
        document.getElementById("moboName").removeAttribute("disabled");

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("caseName").innerHTML = this.responseText;                
            }
        };

        xmlhttp.open("GET", "./php/caseSearch.php?brand=" + caseBrandText + "&sortby=" + caseSortText, true);
        xmlhttp.send();

    })

    $('#addPsuButton').click(function() {
        psuPriceGet();
        psuQueryReplaceInput();

        totalPrice += psuPrice;
        document.getElementById("psuPriceList").innerText = "PSU: " + peso.format(psuPrice);
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });

    $('#remPsuButton').click(function() {
        psuQueryReplaceText(); 
    
        totalPrice -= psuPrice;
        psuPrice = 0;
        document.getElementById("psuPriceList").innerText = "";
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });

    $('#psuSearch').click(function(){
        var psuBrand = document.getElementById("psuBrand");
        var psuBrandText = psuBrand.options[psuBrand.selectedIndex].value;

        var psuSort = document.getElementById("psuSort");
        var psuSortText = psuSort.options[psuSort.selectedIndex].id;
        document.getElementById("moboName").removeAttribute("disabled");
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("psuName").innerHTML = this.responseText;                
            }
        };

        xmlhttp.open("GET", "./php/psuSearch.php?brand=" + psuBrandText + "&sortby=" + psuSortText, true);
        xmlhttp.send();

    })

    $('#addGpuButton').click(function() {
        gpuPriceGet();
        gpuQueryReplaceInput();

        gpuPrice += 0.00;
        totalPrice += gpuPrice;
        document.getElementById("gpuPriceList").innerText = "GPU: " + peso.format(gpuPrice);
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });



    $('#submitBuild').click(function() {

        var cpuID = document.getElementById("cpuName").value;
        var mobID = document.getElementById("moboName").value;
        var memID = document.getElementById("memName").value;
        var memQty = document.getElementById("memQty").value;
        var stoID = document.getElementById("stoSize").value;
        var caseID = document.getElementById("caseName").value;
        var psuID = document.getElementById("psuName").value;
        var gpuID = document.getElementById("gpuName").value;
        var buildName = document.getElementById("buildName").value;


        if(cpuID != "" && mobID != "" && memID != "" && memQty != "" && cpuID != "" && stoID != "" && caseID != "" && 
            psuID!= "" && gpuID != "" && buildName != ""){
        var xmlhttp = new XMLHttpRequest();
        
        xmlhttp.open("GET", "./php/finalizeBuild.php?caseID=" + caseID + "&drvID=" + stoID + "&memID=" + memID + "&memQty="
            + memQty + "&moboID=" + mobID + "&psuID=" + psuID + "&cpuID=" + cpuID + "&gpuID=" + gpuID + "&name=" + buildName
            , true);
        xmlhttp.send();
        alert("Sucessfully Submitted!");


            // var xmlhttp2 = newXMLHttpRequest();
            // xmlhttp2.onreadystatechange = function(){
            //     if (this.readyState == 4 && this.status == 200) {
            //         string = this.responseText;
            //         string = string.replace(/<\/?[^>]+(>|$)/g, "");
            //         alert("This build's number is " + string);              
            //     }
            // };
            // xmlhttp2.open("GET", "./php/indexBuild.php", true);
            // xmlhttp2.send();
            var xmlhttp2 = new XMLHttpRequest();
        xmlhttp2.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                string = this.responseText;
                string = string.replace(/<\/?[^>]+(>|$)/g, "");
                alert("This build's number is " + string);              
            }
        };
        xmlhttp2.open("GET", "./php/indexBuild.php", true);
        xmlhttp2.send();

        }
        else
            alert("Incomplete Details!");

    });
    $('#testButton').click(function(){
        var xmlhttp2 = new XMLHttpRequest();
        xmlhttp2.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                string = this.responseText;
                string = string.replace(/<\/?[^>]+(>|$)/g, "");
                alert("This build's number is " + string);              
            }
        };
        xmlhttp2.open("GET", "./php/indexBuild.php", true);
        xmlhttp2.send();

    });

    $('#addGpuButton').click(function() {
        gpuPriceGet();
        gpuQueryReplaceInput();

        gpuPrice += 0.00;
        totalPrice += gpuPrice;
        document.getElementById("gpuPriceList").innerText = "GPU: " + peso.format(gpuPrice);
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });



    $('#remGpuButton').click(function() {
        gpuQueryReplaceText();
        totalPrice -= gpuPrice;
        gpuPrice = 0.00;
        document.getElementById("gpuPriceList").innerText = "";
        document.getElementById("totalPriceList").innerText = "Total: " + peso.format(totalPrice);
    });


    $('#gpuSearch').click(function(){
        var gpuBrand = document.getElementById("gpuBrand");
        var gpuBrandText = gpuBrand.options[gpuBrand.selectedIndex].value;

        var gpuSort = document.getElementById("gpuSort");
        var gpuSortText = gpuSort.options[gpuSort.selectedIndex].id;

        document.getElementById("gpuName").removeAttribute("disabled");
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("gpuName").innerHTML = this.responseText;                
            }
        };

        xmlhttp.open("GET", "./php/gpuSearch.php?brand=" + gpuBrandText + "&sortby=" + gpuSortText, true);
        xmlhttp.send();

    })



    

});