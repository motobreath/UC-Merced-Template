$(function(){
    if($(".adminUsers").size()>0){
        //add user functionallity
        $("#addAdmin").on("mouseover",function(){
            if(!addAdmin.isInit){
                addAdmin.init()
            }


        });

        //add delete functionallity
        deleteAdmins.init();


    }
})

var addAdmin={
    isInit:false,
    init:function(){
        addAdmin.isInit=true;
        $("#addAdmin").submit(function(){
            var self=$(this);
            var errors="";
            var admin=$("#ucmnetid").val();
            addAdmin.removeErrors();

            if(self.find("#ucmnetid").val()==""){
                addAdmin.raiseError("Please enter a UCMNETID to add an Administrator");
                return false;
            }
            var checkAdmin=addAdmin.validateAdmin(admin);
            if(checkAdmin){

                return false;
            }

            return true;

        })
    },

    raiseError:function(error){
        var errorDiv="<p class='red addAdminError'>";
        var errorDivEnd="</p>"
        $("#addAdmin").prepend(errorDiv + error + errorDivEnd);
    },

    removeErrors:function(){
        $(".addAdminError").remove();
    },

    validateAdmin:function(admin){
        var errors=false;
        $.ajax({
            type: 'POST',
            async:false,
            url: "/admin/checkadmin/format/json",
            data: {"admin":admin},
            success: function(response){
                if(!response.messages.isValid){
                    addAdmin.raiseError("That user is already an admin.");
                    errors=true;
                }

            },
            error:function(){
                addAdmin.raiseError("There was an error processing your request. Please try again.");
                errors=true;
            },
            dataType: "json"
        });
        return errors;
    }
}

var deleteAdmins = {

    init: function(){
        this.attachEvents();
    },

    doDelete:function(ID){
       return $.post("/admin/modifyadmin/format/json",{"admin":ID});
    },

    attachEvents: function(){
        $("#administratorsTable .DA").click(function(){
            self=$(this);
            ID=self.data("admin");
            $.when(deleteAdmins.doDelete(ID))
                .then(function(){
                    self.closest("tr").remove();
                    doStripes("#administratorsTable");
                    deleteAdmins.displayStatus("Success! Admin has been deleted")
                })
                .fail(function(){
                    deleteAdmins.displayStatus("There was an error deleting that admin", "error");
                });

        })
    },

    displayStatus: function(msg,type){
        $("#msgContainer").html("");
        msg="<div class='msg " + type +"'>" + msg + "</div>";
        $("#msgContainer").html(msg)
    }


}

function doStripes(table){
    table=$(table);
    if(table.size()==0){
        return;
    }

    table.find(".even").removeClass("even");
    table.find("tr:even").addClass("even");
}


