
    // Obtener la referencia del input de búsqueda
    const searchInput = document.getElementById('search-input');

    // Agregar un evento de escucha al input de búsqueda
    searchInput.addEventListener('input', function() {
        filterTable(searchInput.value.trim().toLowerCase());
    });

    // Función para filtrar los elementos de la tabla
    function filterTable(searchValue) {
        const tableRows = document.querySelectorAll('.table tbody tr');

        tableRows.forEach(function(row) {
            const cells = row.querySelectorAll('td');
            let match = false;

            cells.forEach(function(cell) {
                if (cell.textContent.toLowerCase().includes(searchValue)) {
                    match = true;
                }
            });

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
