$(document).ready(function(){
    $(function() {
        var table = $('#users').DataTable({
            "ordering": false,
            "language": {
                "decimal":        "",
                "emptyTable":     "Không có dữ liệu",
                "info":           "Hiển thị từ _START_ đến _END_ của _TOTAL_ mục",
                "infoEmpty":      "Hiển thị 0 đến 0 của 0 mục",
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
                url: "/admin/users/getlist",
                data: function (d) {
                    d.status = $('#status').val();
                    d.search = $('#search_users').val();
                }
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'gender_text', name: 'gender' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' },
            ]
        });

        $('#reset_filter').click(function (){
            reset();
            $('#filter_default').attr('selected');

        });
        function reset(e){
            $('#status').val("");
            $('#filter_status').submit();
            table.draw();
            e.preventDefault();
        }
        $('#filter-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        $("#search_users").keyup(function(e){
            table.draw();
            e.preventDefault();
        });
    });
});
$(document).on('click','.status_check',function(){
        Swal.fire({
            title: 'Bạn có chắn chắn không?',
            text: "Xác nhận thực hiện",
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Huỷ',
            confirmButtonText: 'Xác nhận'
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                var id = $(this).data('id');
                var $this = $(this);
                $.ajax({
                    url:'/admin/users/lock-user',
                    type:'POST',
                    dataType: "JSON",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{
                        id:id,
                    },
                    success:function(data){
                        if(data.status==200){
                            if(data.user_status){
                                $('#users').DataTable().ajax.reload( null, false );
                                Swal.fire({
                                    position: 'center-center',
                                    icon: 'success',
                                    title: 'Mở thành công',
                                    showConfirmButton: false,
                                    timer: 1800
                                });
                            }else{
                                $('#users').DataTable().ajax.reload( null, false );
                                Swal.fire({
                                    position: 'center-center',
                                    icon: 'success',
                                    title: 'Khoá thành công',
                                    showConfirmButton: false,
                                    timer: 1800
                                });
                            }
                            
                        }
                    }
                });

            }
        });
});
$(document).on('click','.reset_email',function(){
        Swal.fire({
            title: 'Bạn có chắn chắn không?',
            text: "Xác nhận thực hiện reset mật khẩu",
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Huỷ',
            confirmButtonText: 'Xác nhận'
        }).then((willSend) => {
            if (willSend.isConfirmed) {
                var id = $(this).data('id');
                $.ajax({
                    url:'/admin/users/send-email',
                    method:'POST',
                    dataType: "JSON",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{
                        id:id,
                    },
                    success: function (data)
                    {
                        if(data.status==200){
                            Swal.fire({
                                position: 'center-center',
                                icon: 'success',
                                title: 'Đã làm mới mật khẩu thành công',
                                showConfirmButton: false,
                                timer: 1800
                            })
                        }
                    }
                });
            }
        });
});
$(document).on('click','.btn-show',function(){
        var url = $(this).attr("data-url");
        $.ajax({
            type: "get",
            url: url,
            dataType:"json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $("#modal-result").html(response);
            },
        });
});