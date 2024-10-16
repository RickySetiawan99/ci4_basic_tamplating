"use strict";

function initSimpleDataTable(selector, url, filters = {}, columns = []) {
    var table = $(selector).DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: url,
            type: "POST",
            data: function (d) {
                // Tambahkan nilai filter ke parameter ajax
                $.each(filters, function (key, filterSelector) {
                d[key] = $(filterSelector).val();
                });
            },
        },
        columns: columns,
        pagingType: "full_numbers", // Pagination dengan ikon lengkap
        language: {
            paginate: {
                first: "<i class='fas fa-angle-double-left'></i>", // Ikon double chevron kiri
                last: "<i class='fas fa-angle-double-right'></i>", // Ikon double chevron kanan
                previous: "<i class='fas fa-chevron-left'></i>", // Ikon chevron kiri
                next: "<i class='fas fa-chevron-right'></i>", // Ikon chevron kanan
            },
        },
    });

    // Integrasi delete action
    $(selector).on("click", ".btn-delete", function (e) {
        e.preventDefault();
        var el = this;
        var route = $(this).attr("data-route"); // Ambil URL dari attribute data-route

        Swal.fire({
            title: "Apakah yakin hapus data ini?",
            text: "Lanjutkan untuk menghapus",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: "Menghapus...",
                    text: "Mohon tunggu",
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    },
                });
                $.ajax({
                    url: route,
                    type: "GET", // Tipe request GET sesuai dengan route
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status == true) {
                            table.ajax.reload(); // Reload DataTable setelah berhasil hapus
                            Swal.fire("Deleted!", response.message, "success");
                        } else {
                            Swal.fire("Failed!", response.message, "error");
                        }
                        $.unblockUI(); // Unblock UI setelah proses selesai
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        Swal.fire("Error!", "Terjadi kesalahan", "error");
                    },
                });
            }
        });
    });

    return table;
}
