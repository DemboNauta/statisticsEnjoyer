document.addEventListener("DOMContentLoaded", () => {
    const botonesEditar = document.querySelectorAll('.btn-editar');
    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function() {
            const enviarBtn = document.getElementById('enviarBtn');
            const nomUsuario = boton.getAttribute('dataNom');
            const spanUsu = document.getElementById("nomUsuEdi");
            spanUsu.textContent = nomUsuario;
            const nombre = document.getElementById("nuevoNomUsuario");
            nombre.value = nomUsuario;
            const nuevaContrasena = document.getElementById("nuevaContrasena");

            enviarBtn.addEventListener("click", () => {
                enviarBtn.setAttribute('href', '../modificaUsuarios/editarUsuario.php?usuario=' + nomUsuario + "&nombre=" + nombre.value + "&contrasena=" + nuevaContrasena.value);
            })
        });
    });

    const botonesBorrar = document.querySelectorAll('.btn-borrar');
    botonesBorrar.forEach(btn => {
        btn.addEventListener("click", (ev) => {
            let conf = confirm("¿Estás seguro de que quieres borrar este usuario?");
            if (!conf) {
                ev.preventDefault();
            }
        })
    })

    const botonesMostrarPassword = document.querySelectorAll('.btn-show-password');
    botonesMostrarPassword.forEach(button => {
        button.addEventListener('click', function() {
            mostrarPassword(button);
        });
    });

});

function mostrarPassword(button) {
    console.log(button);
    let cambio = button.previousElementSibling;
    let icono = button.querySelector('.icon');

    if (cambio.type === "password") {
        cambio.type = "text";
        icono.classList.remove('fa-eye-slash');
        icono.classList.add('fa-eye');
    } else {
        cambio.type = "password";
        icono.classList.remove('fa-eye');
        icono.classList.add('fa-eye-slash');
    }
}
