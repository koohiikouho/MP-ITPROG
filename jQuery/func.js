var cpuPrice = 0;
var moboPrice = 0;
var totalPrice = 0;
var socketID = "1";

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
    $('#cpuDataList').hide(); //alter this so that it has the info
    $('#cpuLoading').show();
    //you should probably do some php here



    //cpu specs should go here into this function after you're done implementing AJAX

    var brand = document.getElementById("cpuBrand");
    var name = document.getElementById("cpuName");

    var xmlhttp = new XMLHttpRequest();
    var description = "";
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            
            description = this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/cpuAdd.php?name=" + name.options[name.selectedIndex].text, false);
    xmlhttp.send();


    cpuShowQueryReturn( brand.options[brand.selectedIndex].text + " "+ name.options[name.selectedIndex].text + " - " + peso.format(cpuPrice), //top text
        description); //bottom text
    

    
    
    $('#cpuLoading').hide();
    $('#addCpuButton').hide();
    $('#remCpuButton').show();
    //SHOULD IMPLEMENT FUNCTION HERE THAT DISPLAYS IT AT THE SIDEBAR


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

    var name = document.getElementById("moboChipset");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            moboPrice =  this.responseText;
        }
    };

    xmlhttp.open("GET", "./php/moboPrice.php?name=" + name.options[name.selectedIndex].text, false);
    xmlhttp.send();

    moboPrice = parseFloat(moboPrice);


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
    $('#storDataList').hide();
    

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

function queryReplaceInput(cardDataList, cardLoading, addButton, remButton,
    itemProdName, itemProdDesc) {

    $(cardDataList).hide(); 
    $(cardLoading).show();  //alter this so that it has the info

    
    
    //you should probably do some php here
    //make it so that it is variable
    newItemProdName = "Mamboard";
    newItemProdDesc = "Mamthousand Speed";
    //specs should go here into this function after you're done implementing AJAX
    showQueryReturn(itemProdName, itemProdDesc, newItemProdName, newItemProdDesc);

    $(cardLoading).hide();

    $(addButton).hide();
    $(remButton).show();
    //SHOULD IMPLEMENT FUNCTION HERE THAT DISPLAYS IT AT THE SIDEBAR


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
            if (this.readyState == 4&& this.status == 200) {
                document.getElementById("cpuName").innerHTML = this.responseText;                
            }
        };
        
        xmlhttp.open("GET", "./php/cpuSearch.php?brand=" + cpuBrandText + "&cores=" + cpuCoresText , true);
        xmlhttp.send();


    })

    $('#addMoboButton').click(function(){
        unlockMemory();
        queryReplaceInput('#moboDataList', '#moboLoading', '#addMoboButton', '#remMoboButton', 
            '#moboProdName', '#moboDesc'); //REPLACE WITH MOBOREPLACEINPUT INSTEAD OF THIS BULLSHIT
        
        
    });    

    $('#remMoboButton').click(function(){
        lockMemory();
        queryReplaceText('#moboDataList', '#moboLoading', '#addMoboButton', '#remMoboButton', 
            '#moboProdName', '#moboDesc'); //REPLACE WITH MOBOREPLACEINPUT INSTEAD OF THIS BULLSHIT
    });

    $('#moboSearch').click(function(){
        
        var moboBrand = document.getElementById("moboBrand");
        
        var moboBrandText = moboBrand.options[moboBrand.selectedIndex].value;
        var moboChipset = document.getElementById("moboChipset");

        var moboChipsetText = moboChipset.options[moboChipset.selectedIndex].value;
        document.getElementById("moboID").removeAttribute("disabled");


        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4&& this.status == 200) {
                document.getElementById("moboID").innerHTML = this.responseText;                
            }
        };
        
        xmlhttp.open("GET", "./php/moboSearch.php?brand=" + moboBrandText + "&chipset=" + moboChipsetText , true);
        xmlhttp.send();


    })

});