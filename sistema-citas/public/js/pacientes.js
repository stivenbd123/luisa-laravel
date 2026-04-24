function openModal(accion, data = null) {

    const modal = document.getElementById('pacienteModal');
    const form  = document.getElementById('pacienteForm');

    modal.style.display = 'flex';

    // LIMPIAR METHOD SI EXISTE
    let methodField = document.getElementById('methodField');
    if (methodField) methodField.remove();

    if (accion === 'editar' && data) {

        document.getElementById('modalTitle').innerText = 'Editar Paciente';

        // ✅ URL PARA UPDATE
        form.action = '/pacientes/' + data.id_paciente;

        // ✅ MÉTODO PUT (Laravel)
        let method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'PUT';
        method.id = 'methodField';
        form.appendChild(method);

        // ✅ CARGAR DATOS
        document.getElementById('id_paciente').value = data.id_paciente;
        document.getElementById('primer_nombre').value = data.primer_nombre || '';
        document.getElementById('segundo_nombre').value = data.segundo_nombre || '';
        document.getElementById('primer_apellido').value = data.primer_apellido || '';
        document.getElementById('segundo_apellido').value = data.segundo_apellido || '';
        document.getElementById('numero_de_cedula').value = data.numero_de_cedula || '';
        document.getElementById('correo_electronico').value = data.correo_electronico || '';
        document.getElementById('numero_de_celular').value = data.numero_de_celular || '';
        document.getElementById('direccion').value = data.direccion || '';

    } else {

        document.getElementById('modalTitle').innerText = 'Nuevo Paciente';

        // ✅ URL PARA CREAR
        form.action = '/pacientes';

        // LIMPIAR FORM
        form.reset();
        document.getElementById('id_paciente').value = '';
    }
}


// CERRAR MODAL
function closeModal() {
    document.getElementById('pacienteModal').style.display = 'none';
}


// CLICK FUERA DEL MODAL
window.onclick = function(event) {
    const modal = document.getElementById('pacienteModal');
    if (event.target === modal) {
        closeModal();
    }
};