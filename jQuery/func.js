
function removeQueryReturn(itemProdName, itemProdDesc){
    $(itemProdName).text("");
    $(itemProdDesc).text("");
    $(itemProdName).hide();
    $(itemProdDesc).hide();
}

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

    var name = document.getElementById("cpuBrand");
    cpuShowQueryReturn( name.options[name.selectedIndex].text, "Hello");
    

    
    
    $('#cpuLoading').hide();
    $('#addCpuButton').hide();
    $('#remCpuButton').show();
    //SHOULD IMPLEMENT FUNCTION HERE THAT DISPLAYS IT AT THE SIDEBAR


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

}

function populateCPUBrands(){

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
function populateCPUCores(){

}

$(document).ready(function(){
    
    hideAtStart();
    populateCPUBrands();
    populateCPUCores();

    //don't use these or try to replicate it, this shit suckss
    $('#addCpuButton').click(function(){
        cpuQueryReplaceInput();
        unlockMoboMemory();
        
    });

    $('#remCpuButton').click(function(){
        cpuQueryReplaceText();
        lockMoboMemory();
    });    


        

    $('#cpuSearch').click(function(){
        
        var cpuBrand = document.getElementById("cpuBrand");
        
        var cpuBrandText = cpuBrand.options[cpuBrand.selectedIndex].text;
        
        var cpuCores = document.getElementById("cpuCores");
        var cpuCoresText = cpuCores.options[cpuCores.selectedIndex].text;

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


        queryReplaceInput('#moboDataList', '#moboLoading', '#addMoboButton', '#remMoboButton', 
            '#moboProdName', '#moboDesc');


    });    

    $('#remMoboButton').click(function(){
        queryReplaceText('#moboDataList', '#moboLoading', '#addMoboButton', '#remMoboButton', 
            '#moboProdName', '#moboDesc');
    });    

});