$(document).ready(function(){
    $(function() {
        var table = $('#courses').DataTable({
            "ordering": true,
            "columnDefs": [
                { "targets": [0,1,2,3,4,7,8], "orderable": false }
            ],
            search: {
                "regex": true
            },
            "language": {
                "decimal":        "",
                "emptyTable":     "Không có dữ liệu",
                "info":           "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                "infoEmpty":      "Hiển thị 0 tới 0 của 0 mục",
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
                url: "/admin/courses-manager/get",
                data: function (d) {
                    d.search = $('#search_courses').val();
                    d.status = $('#status').val();
                    d.category_id = $('#category').val();
                    d.tags = $('#tags').val();

                }
            },
            columns: [
                { data: 'image', name: 'image' },
                { data: 'name', name: 'name' },
                { data: 'type', name: 'type' },
                // { data: 'category_id', name: 'category_id' },
                // { data: 'tags', name: 'tags' },
                { data: 'staff_id', name: 'staff_id' },
                // { data: 'status', name: 'status' },
                { data: 'price', name: 'price' },
                { data: 'published_at', name: 'published_at' },
                { data: 'created_at', name: 'created_at' },
                { data: 'publish_course', name: 'publish_course' },
                { data: 'action', name: 'action' },
            ],
        });

        function reset(e){
            $('#category').val("");
            $('#status').val("");
            $('#tags').val("");
            $('#fillter_form').submit();
            table.draw();
            e.preventDefault();
        };
        $('#reset_fllter').click(function (){
            reset();
            $('.fillter_default').attr('selected');

        });
        $('#fillter-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        $("#search_courses").keyup(function(e){
            table.draw();
            e.preventDefault();
        });

    });
    function rm_asc(){
        $('#th_1').removeClass('sorting_asc');
    }
    rm_asc();
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
                    url: "/admin/courses-manager/"+id,
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
                            $('#courses').DataTable().ajax.reload( null, false );
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

$(document).on('click', '#publish', function (){
    Swal.fire({
        title: 'Bạn có chắn chắn không?',
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
                    url: "/admin/courses-manager/publishCourse/"+id,
                    type: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {

                    },
                    success: function (data)
                    {
                        if(data.status==200){
                            if(data.staff_status){
                                $('#courses').DataTable().ajax.reload( null, false );
                                Swal.fire({
                                    position: 'center-center',
                                    icon: 'success',
                                    title: 'Đã phát hành khoá học',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                            else if(data.check_publish == 0){
                                $('#courses').DataTable().ajax.reload( null, false );
                                Swal.fire({
                                    position: 'center-center',
                                    icon: 'error',
                                    title: 'Đã quá thời gian bắt đầu khoá học ',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else if(data.check_publish == 1){
                                $('#courses').DataTable().ajax.reload( null, false );
                                Swal.fire({
                                    position: 'center-center',
                                    icon: 'error',
                                    title: 'Khoá học chưa có giảng viên ',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }else{
                                $('#courses').DataTable().ajax.reload( null, false );
                                Swal.fire({
                                    position: 'center-center',
                                    icon: 'success',
                                    title: 'Đã huỷ phát hành ',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    },
                    error:function ()
                    {
                        Swal.fire({
                            position: 'center-center',
                            icon: 'error',
                            title: 'Thao tác thất bại!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
        }
    });
});
$(document).on('click','.course_show',function(){
    var url = $(this).attr("data-url");
    $.ajax({
        type: "post",
        url: url,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        success: function (response) {
            console.log(response);
            $("span#name").text(response.data.name);
            $("span#type").text(response.data.typeText);
            $("span#category_id").text(response.data.categoryName);
            $("span#tags").html(response.data.tagView);
            $("span#staff_id").text(response.data.staffName);
            $("span#status").text(response.data.statusText);
            $("span#price").text(response.data.price+'vnđ');
            $("span#published_at").text(response.data.published_at);
            // $("span#created_at").text(response.data.created_at);
            $("span#start_time").text(response.data.start_time);
            $("span#end_time").text(response.data.end_time);
            $("span#key").text(response.data.key);
            $("span#description").text(response.data.description);
            $("#tbody_order_course").html(response.data.orderCourse);

        },
    });
});









