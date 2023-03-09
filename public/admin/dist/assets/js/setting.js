$(document).on('click', '#change_password', function (){
    Swal.fire({
        title: 'Xác nhận đổi mật khẩu?',
        text: "Bạn sẽ bị đăng xuất khỏi hệ thống",
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Huỷ',
        confirmButtonText: 'Xác nhận'
    }).then((Change) => {
        if (Change.isConfirmed) {
            $("#form-submit").submit();
        }
    });
});