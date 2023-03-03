function Buscar() {
    var tabla = document.getElementById('table_search');
    var busqueda = document.getElementById('search').value.toLowerCase();

    var cellsOfRow="";
    var found=false;
    var compareWith="";
    for (var i = 1; i < tabla.rows.length; i++) {
        cellsOfRow = tabla.rows[i].getElementsByTagName('td');
        found = false;
        for (var j = 0; j < cellsOfRow.length && !found; j++) { compareWith = cellsOfRow[j].innerHTML.toLowerCase(); if (busqueda.length == 0 || (compareWith.indexOf(busqueda) > -1))
            {
                found = true;
            }
        }
        if(found)
        {
            tabla.rows[i].style.display = '';
        } else {
            tabla.rows[i].style.display = 'none';
        }

    }
}

function BuscarOption() {
    var select = document.getElementById('select_search');
    var busqueda = document.getElementById('search').value.toLowerCase();

    var cellsOfRow="";
    var found=false;
    var compareWith="";
    for (var i = 1; i < select.rows.length; i++) {
        cellsOfRow = select.rows[i].getElementsByTagName('option');
        found = false;
        for (var j = 0; j < cellsOfRow.length && !found; j++) { compareWith = cellsOfRow[j].innerHTML.toLowerCase(); if (busqueda.length == 0 || (compareWith.indexOf(busqueda) > -1))
            {
                found = true;
            }
        }
        if(found)
        {
            select.rows[i].style.display = '';
        } else {
            select.rows[i].style.display = 'none';
        }

    }
}