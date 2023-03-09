$(document).ready(function(){
    $(function() {
        var table = $('#units').DataTable({
            "ordering": false,
            "language": {
                "decimal":        "",
                "emptyTable":     "Không có dữ liệu",
                "info":           "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
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
                url: "/admin/units/"+$('#id_course1').val()+"/getList",
                data: function (d) {
                    d.role = $('#role').val();
                    d.search = $('#search_staffs').val();

                }
            },
            columns: [
                { data: 'index', name: 'index' },
                { data: 'name', name: 'name' },
                {data:'created_at', name:'created_at'},
                { data: 'action', name: 'action' },
            ]
        });


        function reset(e){
            $('#role').val("");
            $('#fillter_form').submit();
            table.draw();
            e.preventDefault();
        }
        $('#reset_fllter').click(function (){
            reset();
            $('#fillter_default').attr('selected');

        });
        $('#fillter-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        $("#search_staffs").keyup(function(e){
            table.draw();
            e.preventDefault();
        });
    });
});
$(document).on('click','.unit_show',function(){
    var url = $(this).attr("data-url");
    console.log(url);
    $.ajax({
        method: "post",
        url: url,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        success: function (response) {
            console.log(response.data);
            $("span#name").text(response.data.name);
            $("span#courseName").text(response.data.courseName);
            $("#video").html(response.data.video);
            $("#file").html(response.data.file);

        },
    });
});
$(document).on('click', '.show_confirm', function (){
    Swal.fire({
        title: 'Bạn có chắn chắn không?',
        text: "Bạn sẽ không khôi phục được lại dữ liệu",
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Huỷ',
        confirmButtonText: 'Xoá'
    }).then((willDelete) => {
        if (willDelete.isConfirmed) {
            //   form.submit();
            var id = $(this).data("id");
            var $this = $(this);
            $.ajax(
                {
                    url: "/admin/units/delete/"+id,
                    method: 'DELETE',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {

                    },
                    success: function (data)
                    {
                        if(data.status==200){
                            $('#units').DataTable().ajax.reload( null, false );
                            Swal.fire({
                                position: 'center-center',
                                icon: 'success',
                                title: 'Đã xoá thành công',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function ()
                    {
                        Swal.fire({
                            position: 'center-center',
                            icon: 'error',
                            title: 'Xoá thất bại!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
        }
    });
});
