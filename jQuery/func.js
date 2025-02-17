
function cpuShowQueryReturn(cpuName){
    $('#cpuname').text(cpuName);
    $('#cpudesc').text("5 times the mambos");

    $('#cpuname').show();
    $('#cpudesc').show();

}
function cpuRemoveQueryReturn(){
    $('#cpuname').text("");
    $('#cpuname').hide();
    $('#cpudesc').hide();
}
function cpuQueryReplaceInput() {
    
    // insert shit here

    


    $('#cpuDataList').hide(); //alter this so that it has the info
    $('#cpuloading').show();
    //you should probably do some php here


    
    
    //cpu specs should go here into this function after you're done implementing AJAX

    cpuShowQueryReturn("AMD MamboX3D");
    

    
    
    $('#cpuloading').hide();
    $('#addcpubutton').hide();
    $('#removecpubutton').show();
}

function cpuQueryReplaceText() {

    $('#cpuDataList').show();
    $('#description').hide(); // Replace input with text

    cpuRemoveQueryReturn();

    $('#removecpubutton').hide();
    $('#addcpubutton').show();

}

function hideAtStart(){
    $('#removecpubutton').hide();
    $('#cpuloading').hide();
    $('#cpuname').hide();
    $('#cpudesc').hide();
}

$(document).ready(function(){

    cpuSearchCount = 0;
    hideAtStart();

    $('#addcpubutton').click(function(){
        cpuQueryReplaceInput();
        document.getElementById('mobBrand').disabled = false;
        document.getElementById('mobChipset').disabled = false;
        document.getElementById('mobPart').disabled = false;
        document.getElementById('ramBrand').disabled = false;
        document.getElementById('ramSize').disabled = false;
        document.getElementById('ramName').disabled = false;
        document.getElementById('ramQty').disabled = false;
    });

    $('#removecpubutton').click(function(){
        cpuQueryReplaceText();
        document.getElementById('mobBrand').disabled = true;
        document.getElementById('mobChipset').disabled = true;
        document.getElementById('mobPart').disabled = true;
        document.getElementById('ramBrand').disabled = true;
        document.getElementById('ramSize').disabled = true;
        document.getElementById('ramName').disabled = true;
        document.getElementById('ramQty').disabled = true;
    });    

});