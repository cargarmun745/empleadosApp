$('#modalDelete').on('shown.bs.modal', function (event) {
    let deleteEmpleado = document.getElementById('deleteEmpleado');
    let element = event.relatedTarget;
    console.log(element);
    let action = element.getAttribute('data-url');
    let name = element.getAttribute('data-name');
    deleteEmpleado.innerHTML = name;
    let form = document.getElementById('modalDeleteEmpleadoForm');
    form.action = action;
    
})