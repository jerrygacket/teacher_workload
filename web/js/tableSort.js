$(document).ready(function () {
    if (document.getElementById('commonLoad')) {
        var table = $('#commonLoad').DataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
            "language": {
                //"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json",
                "sProcessing":   "Подождите...",
                "sLengthMenu":   "Показать _MENU_ записей",
                "sZeroRecords":  "Записи отсутствуют.",
                "sInfo":         "Записи с _START_ до _END_ из _TOTAL_ записей",
                "sInfoEmpty":    "Записи с 0 до 0 из 0 записей",
                "sInfoFiltered": "(отфильтровано из _MAX_ записей)",
                "sInfoPostFix":  "",
                "sSearch":       "Быстрый поиск:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst": "Первая",
                    "sPrevious": "Предыдущая",
                    "sNext": "Следующая",
                    "sLast": "Последняя"
                },
                "oAria": {
                    "sSortAscending":  ": активировать для сортировки столбца по возрастанию",
                    "sSortDescending": ": активировать для сортировки столбцов по убыванию"
                }
            },
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "searchable": false
                },
                {
                    "targets": [ 5 ],
                    "searchable": false
                },
                {
                    "targets": [ 6 ],
                    "searchable": false
                },
                {
                    "targets": [ 7 ],
                    "searchable": false
                },
                {
                    "targets": [ 8 ],
                    "searchable": false
                },
                {
                    "targets": [ 9 ],
                    "searchable": false
                },
                {
                    "targets": [ 13 ],
                    "searchable": true
                }
            ]
        });
    }
    if (document.getElementById('departmentLoad')) {
        var table = $('#departmentLoad').DataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
            "language": {
                //"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json",
                "sProcessing": "Подождите...",
                "sLengthMenu": "Показать _MENU_ записей",
                "sZeroRecords": "Записи отсутствуют.",
                "sInfo": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "sInfoEmpty": "Записи с 0 до 0 из 0 записей",
                "sInfoFiltered": "(отфильтровано из _MAX_ записей)",
                "sInfoPostFix": "",
                "sSearch": "Быстрый поиск:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Первая",
                    "sPrevious": "Предыдущая",
                    "sNext": "Следующая",
                    "sLast": "Последняя"
                },
                "oAria": {
                    "sSortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sSortDescending": ": активировать для сортировки столбцов по убыванию"
                }
            },
        });
    }
    $('.dataTables_length').addClass('bs-select');
    // $('#commonLoad tfoot th').each( function () {
    //     var title = $(this).text();
    //     if (title === "Наименование" || title === "Примечание") {
    //         $(this).html( '<input type="text" placeholder="" />' );
    //     }
    // } );
    //
    // // Apply the search
    // table.columns().every( function () {
    //     var that = this;
    //
    //     $( 'input', this.footer() ).on( 'keyup change clear', function () {
    //         if ( that.search() !== this.value ) {
    //             that
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );
});