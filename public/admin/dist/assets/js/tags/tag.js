$(document).on('click', '.delete', function (){
    Swal.fire({
        title: 'Bạn có chắc chắn không?',
        text: "Bạn sẽ không khôi phục được dữ liệu",
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonColor: '#3083D6',
        cancelButtonText: 'Hủy',
        cancelButtonColor: '#F70008',
        confirmButtonText: 'Đồng ý'
    }).then((result)=>{
        if (result.isConfirmed) {
            var id = $(this).data("id");
            var $this = $(this);
            $.ajax({
                url: "/admin/tags/"+id,
                method: 'DELETE',
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function (data) {
                    $('#table').DataTable().ajax.reload(null,true);
                    if(data.check !== true){
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            title: 'Đã xoá thành công',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        Swal.fire({
                            position: 'center-center',
                            icon: 'error',
                            title: 'Xoá không thành công',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        }
    });
});
$(function() {
    var table = $('#table').DataTable({
        language: {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu",
            "info":           "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
            "infoEmpty":      "Hiển thị 0 đến 0 của 0 mục",
            "infoFiltered":   "(Được lọc từ _MAX_ tất cả mục)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Hiển thị _MENU_",
            "loadingRecords": "Đang tải ...",
            "processing":     "Đang tải ...",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không có dữ liệu",
            "aria": {
                "sortAscending": ": Kích hoạt để sắp xếp cột tăng dần",
                "sortDescending": ": Kích hoạt để sắp xếp cột giảm dần"
            }
        },
        processing: true,
        ordering: false,
        serverSide: true,
        paging: true,
        ajax:{
            type: "GET",
            datatype: "json",
            url: '/admin/tags/list',
            data: function (d) {
                d.search = $('#searchTag').val();
            },
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action'}
        ]
    });
    $('#searchTag').keyup(function(e){
        table.draw();
        e.preventDefault();
    });
});
