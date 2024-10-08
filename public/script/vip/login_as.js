$(document).ready(function () {

    $('#role_id').change(function() {
        $.ajax({
            type: "GET",
            url: window.location.origin + "/utilitas/users/list-by-role",
            data: { 
                role_id: $(this).val(),
                aktif: 1
            },
            dataType: "json",
            beforeSend: function () {
                $("#user_id").html('');
                $("#user_id").append('<option value=""> Loading... </option>')
            },
            success: function (res) {
                dt = res.data;
                $("#user_id").html('');
                $("#user_id").append('<option value=""> - Pilih User - </option>')
                $.each(dt, function(){
                    $("#user_id").append('<option value="'+ this.id +'">'+ this.full_name +' (NIP. '+ this.nip +')</option>')
                })
            }
        });
    });

    $("#form_login_as").submit(function (e) {
        e.preventDefault();

        var data = $('form').serialize();
        var btn = '';
        
        if (!$("#role_id").val())
            return false

        if (!$("#user_id").val())
            return false

        var user_selected = $('#user_id').find(":selected").text();
        const user = user_selected.split(" (NIP");

        Swal.fire({
            title: `Login sebagai ${user[0]}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6C757D',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tutup'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: window.location.origin + "/go-to/login-sebagai",
                    data: data,
                    beforeSend: function () {
                        btn = $("#btn_ambil_alih").html();
                        $("#btn_ambil_alih").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...').attr("disabled", true);
                    },
                    success: function (res) {
                        if(res.status)
                        {
                            $("#btn_ambil_alih").html(btn).attr("disabled", false)

                            Swal.fire({
                                text: 'Berhasil',
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1000
                            });
                            
                            return window.location.href = "/";
                        }
                    }
                });
            }
        })
    })
});