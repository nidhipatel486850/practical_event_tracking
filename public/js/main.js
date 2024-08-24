const MessageManager = {
    show: function (type, content) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        if(type==="error"){
            toastr.error(content);
        }else if(type==="warning"){
            toastr.warning(content);
        }else if(type==="info"){
            toastr.info(content);
        }else{
            toastr.success(content);
        }
        toastr.options.onHidden = function() { console.log("onHide"); };

        setTimeout(function () {

        }, 7000);
    }
};
function submitForm(form){
    event.preventDefault();
    let id=$(form).attr('id');
    let formData = new FormData(form);
    $(form).find(':submit').prop('disabled', true);
    $.ajax({
        type: 'POST',
        url: $(form).attr('action'),
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if(response.status){
                MessageManager.show('success',response.message)
                window.location.href=response.redirection_link;
            }else{
                MessageManager.show('error',response.message);
                $(form).find(':submit').prop('disabled', false);
            }
        },
        error: function(response) {
            if (response.status === 422) {
                let errors = JSON.parse(response.responseText).errors;
                // Clear existing error messages (if any)
                $("#"+id+" .form-group.has-error").removeClass("has-error");
                $("#"+id+" .form-group .text-danger").remove();

                // Display error messages for each field
                for (let field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        let errorMessage = errors[field][0];
                        $("#"+id+" [name='" + field + "']").closest(".form-group")
                            .addClass("has-error")
                            .append("<span class='text-danger d-block'>" + errorMessage + "</span>");
                    }
                }
                $(form).find(':submit').prop('disabled', false);
            }
        }
    });
}

const showDatatableFilter = {
    show:function (){

        let values = [];

        $('.filterDatatable').each(function(){
            if(this.value){
                values.push({'name':this.name,'data':this.value});
            }
        })
        return values;
    }
};

var table;
const showDatatable = {
    show: function (id,url,columns,height="80vh",searching=true,serverSide=true) {
         table = $(id).DataTable({
             "ordering": false,
             searching: searching,
            processing: true,
            serverSide: serverSide,
            paging: true,
            order: [[0, 'desc']],
            // ajax: url,
            scrollCollapse: true,
            scrollY: height,
            ajax: {
                url: url,
                data: function (d) {
                    d.filter=showDatatableFilter.show()
                }
            },
             stateSave: true,
             "bDestroy": true,
            columns:columns,
        });
        return table;
    }
};
function ajaxCall(method,url,formData=[]){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let tmp = null;
    $.ajax({
        type: method,
        url: url,
        data:formData,
        async: false,
        success: function(data)
        {
            const obj = jQuery.parseJSON(data);
            if(obj.status){
                if(obj.message){
                    MessageManager.show('success',obj.message)
                }
            }
            else{
                if(obj.message){
                    MessageManager.show('error',obj.message)
                }
            }
            tmp = data;

        },
        error: function (error) {
            MessageManager.show('error',error.message)
        }
    });
    return tmp;
}
