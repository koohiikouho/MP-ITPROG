
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

    cpuShowQueryReturn("AMD MamboX3D", "16 times the mambos - Todd Howard");
    

    
    
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

$(document).ready(function(){
    
    hideAtStart();

    //don't use these or try to replicate it, this shit suckss
    $('#addCpuButton').click(function(){
        cpuQueryReplaceInput();
        unlockMoboMemory();
    });

    $('#remCpuButton').click(function(){
        cpuQueryReplaceText();
        lockMoboMemory();
    });    

    //

    $('#addMoboButton').click(function(){


        queryReplaceInput('#moboDataList', '#moboLoading', '#addMoboButton', '#remMoboButton', 
            '#moboProdName', '#moboDesc');


    });    

    $('#remMoboButton').click(function(){
        queryReplaceText('#moboDataList', '#moboLoading', '#addMoboButton', '#remMoboButton', 
            '#moboProdName', '#moboDesc');
    });    

});