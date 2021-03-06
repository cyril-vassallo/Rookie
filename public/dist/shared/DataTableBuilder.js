"use strict";
var DataTableBuilder = (function () {
    function DataTableBuilder() {
    }
    DataTableBuilder.prototype.build = function (page) {
        var order = [];
        var category = "";
        var tableId = "";
        if (page === "movies") {
            category = "movies";
            order = [
                [1, "asc"],
                [2, "asc"],
                [3, "asc"],
            ];
            tableId = '#movieTable';
            this.dataTableInit(tableId, category, order);
        }
        else if (page === "actors") {
        }
    };
    DataTableBuilder.prototype.dataTableInit = function (tableId, category, order) {
        $(tableId).DataTable({
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Tous"],
            ],
            order: order,
            "paging": false,
            scrollY: 180,
            language: {
                info: category + " _START_ à _END_ sur _TOTAL_ au total",
                emptyTable: "Aucun " + category,
                lengthMenu: "_MENU_ résultats par page",
                search: "Rechercher : ",
                zeroRecords: "Aucun résultat de recherche",
                paginate: {
                    previous: "Précédent",
                    next: "Suivant",
                },
                sInfoFiltered: "<br/>(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                sInfoEmpty: "résultat 0 à 0 sur 0 au total <br/>",
            },
        });
    };
    return DataTableBuilder;
}());
var dataTable = new DataTableBuilder();
