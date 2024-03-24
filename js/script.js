window.addEventListener("load", ()=>{
    document.getElementById('sidebarCollapse').addEventListener('click', function () {
        let sidebar = document.getElementById('sidebarMenu');
        let textoSidebar = document.getElementById('textoSidebar');
        sidebar.classList.toggle('collapsed');
        if (sidebar.classList.contains('collapsed')) {
            // Si el sidebar está colapsado, cambia el texto del botón a 'Mostrar Sidebar'

            this.innerHTML = '<i class="bi bi-caret-right-fill"></i>';
            textoSidebar.style.display="none";
        } else {
            // Si el sidebar está expandido, cambia el texto del botón a 'Ocultar Sidebar'
            textoSidebar.style.display="block";
            this.innerHTML = '<i class="bi bi-caret-left-fill"></i>';


        }
    });
});