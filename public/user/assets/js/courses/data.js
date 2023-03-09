function myFunction() {
    var checkBox = document.getElementById("f-option");
    var checkBox2 = document.getElementById("g-option");
    var text = document.getElementById("text");
    if (checkBox.checked == true){
        text.style.display = "block";
        return true;
    }else if(checkBox2.checked == true) {
        text.style.display = "none";
    }

}
function  checkVnpay() {
    var checkBox2 = document.getElementById("g-option");
    var text = document.getElementById("text");
    if (checkBox2.checked == true){
        text.style.display = "none";
        return true;
    }
}
function deleteCategories() {
    if( true) {
        Swal.fire({
            title: 'Bạn có chắn chắn mua khóa học này không?',
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
                $('#form').submit()
            }
            sessionStorage.setItem('name', 'Ted Mosby');
        })
    }

}
