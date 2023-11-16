$.fn.dataTable.render.transactionStatus = function () {
    return function ( data, type, row ) {

        if (data == -9){
            return '<span class="badge badge-danger">DELETE</span>';
        }else if (data == 0){
            return '<span class="badge badge-plain">DRAFT</span>';
        }else if(data == 1){
            return '<span class="badge badge-primary">CONFIRM</span>';
        }else if(data == 8){
            return '<span class="badge badge-primary">COMPLETE</span>';
        }else if(data == 9){
            return '<span class="badge badge-danger">CLOSED</span>';
        }else{
            return '<span class="badge badge-warning">INVALID</span>';
        }

    }
};

$.fn.dataTable.render.approvalStatus = function () {
    return function ( data, type, row ) {

        if (data == -9){
            return '<span class="badge badge-danger">VOID</span>';
        }else if(data == -1){
            return '<span class="badge badge-primary">CANCEL APPROVE</span>';
        }else if (data == 0){
            return '<span class="badge badge-plain">OPEN</span>';
        }else if(data == 1){
            return '<span class="badge badge-primary">APPROVE</span>';
        }else{
            return '<span class="badge badge-warning">INVALID</span>';
        }
        
    }
};

$.fn.dataTable.render.yaTidak = function () {
    return function ( data, type, row ) {

        if (data == 0){
            return '<span class="badge badge-plain">Tidak</span>';
        }else if(data == 1){
            return '<span class="badge badge-primary">Ya</span>';
        }else{
            return '<span class="badge badge-warning">INVALID</span>';
        }
        
    }
};