let deleteButton = document.querySelectorAll('.deleteRow');
deleteButton.forEach(element => {
    element.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default action (form submission)
        
        let name = element.getAttribute('data-name');
        let rowName = element.getAttribute('data-row-name');
        let form = element.closest('form');

        Swal.fire({
            title: 'Are you sure?',
            html: `Do you want to delete this ${rowName} <br><strong>${name}</strong>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form if confirmed
            }
        });
    });
});
