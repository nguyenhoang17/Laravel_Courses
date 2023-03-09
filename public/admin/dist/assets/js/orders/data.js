$(document).ready(function(){
    $(function () {
        var table = $('#orders').DataTable({
            "ordering": false,
            "language": {
                "decimal":        "",
                "emptyTable":     "Không có dữ liệu",
                "info":           "Hiển thị _START_ to _END_ of _TOTAL_ mục",
                "infoEmpty":      "Hiển thị 0 to 0 of 0 mục",
                "infoFiltered":   "(Được lọc từ _MAX_ tất cả mục)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Hiển thị _MENU_ mục",
                "loadingRecords": "Đang tải ...",
                "processing":     "Đang tải ...",
                "search":         "Tìm kiếm:",
                "zeroRecords":    "Không có dữ liệu",
                "aria": {
                    "sortAscending":  ": Kích hoạt để sắp xếp cột tăng dần",
                    "sortDescending": ": Kích hoạt để sắp xếp cột giảm dần"

                }
            },
            processing: true,
            serverSide: true,
            paging: true,
            ajax:{
                url: "/admin/orders/list/data",
                data: function (d) {
                    d.status = $('#status').val();
                    d.search = $('#search_orders').val()
                }
            },
            columns: [
                { data: 'order_id' , name: 'order_id' },
                { data: 'update_by', name: 'update_by' },
                { data: 'user_id', name: 'user_id' },
                { data: 'course_id', name: 'course_id' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' },
            ]
        });

        $('#reset_fllter').click(function (){
            reset();
            $('#fillter_default').attr('selected');

        });
        function reset(e){
            $('#status').val("");
            table.draw();
            e.preventDefault();
        }
        $('#fillter-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        $("#search_orders").keyup(function(e){
            table.draw();
            e.preventDefault();
        });
    });
});

$(document).on('click', '.deleteOrder', function (){
    // alert($(this).data("id"));
    Swal.fire({
        title: 'Bạn có chắn chắn hủy đơn hàng không?',
        text: "Xác nhận thực hiện",
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Huỷ',
        confirmButtonText: 'Xác nhận'
    }).then((willDelete) => {
        if (willDelete.isConfirmed) {
            var id = $(this).data("id");
            var $this = $(this);
            $.ajax(
                {
                    url: '/admin/orders/'+id,
                    type: 'GET',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {

                    },
                    success: function (data)
                    {
                        if(data.status_order){
                            $('#orders').DataTable().ajax.reload(null,true);
                            Swal.fire({
                                position: 'center-center',
                                icon: 'success',
                                title: 'Hủy đơn thành công',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },

                });
        }
    });
});

$(document).on('click', '.confirmOrder', function (){
    Swal.fire({
        title: 'Bạn có chắn chắn xác nhận không?',
        text: "Xác nhận thực hiện",
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Huỷ',
        confirmButtonText: 'Xác nhận'
    }).then((willDelete) => {
        if (willDelete.isConfirmed) {
            var id = $(this).data("id");
            var $this = $(this);
            $.ajax(
                {
                    url: '/admin/orders/confirmOrder/'+id,
                    type: 'GET',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {

                    },
                    success: function (data)
                    {
                        $('#orders').DataTable().ajax.reload(null,true);
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            title: 'Xác nhận thành công',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },

                });
        }
    });
});


