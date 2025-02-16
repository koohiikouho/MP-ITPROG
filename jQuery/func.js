function myFunction() {
    alert('Button clicked!');
}

function cpuQueryReplaceInput() {
    var inputValue = $('#cpuDataList').val(); // Get the value of the input field

    //you should probably do some php here


    $('#cpuDataList').replaceWith('<p class="card-text id="description"> You are a fucking retard </p>'); //alter this so that it has the info
    $('#addcpubutton').replaceWith('<button type="button" class="btn btn-outline-danger" id="removecpubutton">Remove</button>')
}

function cpuQueryReplaceText() {
    $('#description').replaceWith('<input class="form-control" list="datalistOptions" id="cpuDataList" placeholder="Type to search...">'); // Replace input with text
    $('#removecpubutton').replaceWith('<button type="button" class="btn btn-outline-success w-100" id="addcpubutton" >+ Add</button>')

}


$(document).ready(function(){
    $('#replaceButton').click(function(){
        replaceInputWithText();
    });


    $('#addcpubutton').click(function(){
        myFunction();
        cpuQueryReplaceInput();
    });
    $('#removecpubutton').click(function(){
        myFunction();
        cpuQueryReplaceText();
    });    

});