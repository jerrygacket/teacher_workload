$(document).ready(function () {
    $('#commonLoad').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
            // "lengthMenu": "Показывать _MENU_ элементов на странице",
            // "zeroRecords": "Нечего фильтровать",
            // "info": "Страница _PAGE_ из _PAGES_",
            // "infoEmpty": "Нет записей",
            // "infoFiltered": "(filtered from _MAX_ total records)"
        }
    });
    $('.dataTables_length').addClass('bs-select');
});