$(document).ready(function(){
    setTimeout(function() {
        $('#successAlert').fadeOut('slow', function() {
            $(this).remove();
        });
        $('#errorAlert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 2000);
})

function deleteItem (e) {
    let id = $(e).data('id')
    let name = $(e).data('name')
    let modul = $(e).data('modul')
    let type = $(e).data('type')
    Swal.fire({
        title: `Hapus ${name}`,
        text: "Apakah kamu yakin hapus?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            if(type) {
                window.location.href = `/admin/${modul}/delete/${type}/${id}`;
            } else {
                window.location.href = `/admin/${modul}/delete/${id}`;
            }
        }
    });
}
$(document).on("input", ".format-number", function() {
    let value = $(this).val().replace(/\./g, "");
    if (!isNaN(value) && value !== "") {
        $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    } else {
        $(this).val("");
    }
});