function deleteCategories(id) {
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
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/categories/'+id,
                type: 'DELETE',
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                },
                success: function(response) {
                    $("#sid"+id).remove();
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: 'Đã xoá thành công',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        }
    })
}
