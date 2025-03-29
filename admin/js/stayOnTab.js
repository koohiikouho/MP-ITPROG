function switchOnLast(tabName){

    switch(tabName){
        case "1":
            $("#AC").addClass("active");
            $("#addComponent").addClass("show active");
            break;
        case "2":
            $("#UC").addClass("active");
            $("#updateComponent").addClass("show active");
            break;
        case "3":
            $("#GR").addClass("active");
            $("#generateReport").addClass("show active");
            break;
        case "4":
            $("#MR").addClass("active");
            $("#manRef").addClass("show active");
            break;
        case "5":
            $("#MB").addClass("active");
            $("#manBuild").addClass("show active");
            break;
    }
}

function switchOnAdd(tabName){
    switch(parseInt(tabName)){
        case 1:
            $("#addcpubut").addClass("active");
            $("#addCPU").addClass("show active");
            break;
        case 2:
            $("#addmobobut").addClass("active");
            $("#addMotherboard").addClass("show active");
            break;           
        case 3:
            $("#addmembut").addClass("active");
            $("#addMemory").addClass("show active");
            break;
        case 4:
            $("#addstobut").addClass("active");
            $("#addStorage").addClass("show active");
            break;
        case 5:
            $("#addcasebut").addClass("active");
            $("#addCase").addClass("show active");
            break;
        case 6:
            $("#addpsubut").addClass("active");
            $("#addPSU").addClass("show active");
            break;
        case 7:
            $("#addgpubut").addClass("active");
            $("#addGPU").addClass("show active");
            break;                
    }
};

function switchOnUpdate(tabName){
    switch(parseInt(tabName)){
        case 1:
            $("#updcpubut").addClass("active");
            $("#updCPU").addClass("show active");
            break;
        case 2:
            $("#updmobobut").addClass("active");
            $("#updMotherboard").addClass("show active");
            break;           
        case 3:
            $("#updmembut").addClass("active");
            $("#updMemory").addClass("show active");
            break;
        case 4:
            $("#updstobut").addClass("active");
            $("#updStorage").addClass("show active");
            break;
        case 5:
            $("#updcasebut").addClass("active");
            $("#updCase").addClass("show active");
            break;
        case 6:
            $("#updpsubut").addClass("active");
            $("#updPSU").addClass("show active");
            break;
        case 7:
            $("#updgpubut").addClass("active");
            $("#updGPU").addClass("show active");
            break;                
    }
};

function switchOnRef(tabName){
    switch(parseInt(tabName)){
        case 1:
            $("#adven").addClass("active");
            $("#addVendors").addClass("show active");
            break;
        case 2:
            $("#edven").addClass("active");
            $("#editVendors").addClass("show active");
            break;           
        case 3:
            $("#adsoc").addClass("active");
            $("#addSocket").addClass("show active");
            break;    
    }
};

$(document).ready(function(){ 
    switchOnLast(localStorage.getItem("tier1Tab"));
    switchOnAdd(localStorage.getItem("addTab"));
    switchOnUpdate(localStorage.getItem("updTab"));
    switchOnRef(localStorage.getItem("manTab"));

    $('#adven').click(function(){
        localStorage.setItem("manTab", 1);
    });

    $('#edven').click(function(){
        localStorage.setItem("manTab", 2);
    });

    $('#adsoc').click(function(){
        localStorage.setItem("manTab", 3);
    });

    $('#updcpubut').click(function(){
        localStorage.setItem("updTab", 1);
    });
    
    $('#updmobobut').click(function(){
        localStorage.setItem("updTab", 2);
    });
    
    $('#updmembut').click(function(){
        localStorage.setItem("updTab", 3);
    });
    
    $('#updstobut').click(function(){
        localStorage.setItem("updTab", 4);
    });
    
    $('#updcsebut').click(function(){
        localStorage.setItem("updTab", 5);
    });
    
    $('#updpsubut').click(function(){
        localStorage.setItem("updTab", 6);
    });
    
    $('#updgpubut').click(function(){
        localStorage.setItem("updTab", 7);
    });
    



    $('#addcpubut').click(function(){
        localStorage.setItem("addTab", 1);
    });

    $('#addmobobut').click(function(){
        localStorage.setItem("addTab", 2);
    });

    $('#addmembut').click(function(){
        localStorage.setItem("addTab", 3);
    });

    $('#addstobut').click(function(){
        localStorage.setItem("addTab", 4);
    });

    $('#addcasebut').click(function(){
        localStorage.setItem("addTab", 5);
    });

    $('#addpsubut').click(function(){
        localStorage.setItem("addTab", 6);
    });

    $('#addgpubut').click(function(){
        localStorage.setItem("addTab", 7);
    });



    $('#AC').click(function(){
        localStorage.setItem("tier1Tab", "1");
    });

    $('#AC').click(function(){
        localStorage.setItem("tier1Tab", "1");
    });

    $('#UC').click(function(){
        localStorage.setItem("tier1Tab", "2");
    });

    $('#GR').click(function(){
        localStorage.setItem("tier1Tab", "3");
    });

    $('#MR').click(function(){
        localStorage.setItem("tier1Tab", "4");
    });

    $('#MB').click(function(){
        localStorage.setItem("tier1Tab", "5");
    });
});