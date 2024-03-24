window.addEventListener("load", ()=>{
    const botonesSubir = document.querySelectorAll('input[type="submit"]');
    botonesSubir.forEach(boton => {
                boton.addEventListener('click', function() {
                    const idUsuario = boton.getAttribute('data-id');
                    const enviarBtn = document.getElementById('enviarBtn');
                    const nomUsuario=boton.getAttribute('dataNom');
                    const spanUsu=document.getElementById("nomUsuEdi");
                    spanUsu.textContent=nomUsuario;
                    const nombre=document.getElementById("nuevoNomUsuario");
                    nombre.value=nomUsuario;
                    const nuevaContrasena=document.getElementById("nuevaContrasena");
                    
                    enviarBtn.addEventListener("click", ()=>{
                        enviarBtn.setAttribute('href', '../modificaUsuarios/editarUsuario.php?id=' + idUsuario + "&nombre=" + nombre.value + "&contrasena=" + nuevaContrasena.value);
                    })
                });
            });

            const botonesBorrar=document.querySelectorAll('.btn-borrar');
            botonesBorrar.forEach(btn=>{
                btn.addEventListener("click", (ev)=>{
                    let conf=confirm("¿Estás seguro de que quieres borrar este usuario?");
                    if(!conf){
                        ev.preventDefault();
                    }
                })
            })
});
