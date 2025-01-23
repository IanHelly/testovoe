document.addEventListener('DOMContentLoaded', function () {
    const addEmployeeBtn = document.getElementById('addEmployeeBtn');
    const employeeModal = document.getElementById('employeeModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const employeeForm = document.getElementById('employeeForm');
    const saveEmployeeBtn = document.getElementById('saveEmployeeBtn');
    const employeesTable = document.getElementById('employeesTable').getElementsByTagName('tbody')[0];

    addEmployeeBtn.addEventListener('click', function () {
        document.getElementById('modalTitle').textContent = "Add New Employee";
        employeeForm.reset(); // Сбрасываем видимые поля
        document.getElementById('id').value = '';
        saveEmployeeBtn.dataset.action = 'add';
        employeeModal.style.display = 'flex';
    });

    closeModalBtn.addEventListener('click', function () {
        employeeModal.style.display = 'none';
    });

    employeeForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(employeeForm);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/employees', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', window.csrfToken);
        xhr.onload = function () {
            if (xhr.status === 200) {
                fetchEmployees();
                employeeModal.style.display = 'none';
            } else {
                alert('Error: ' + xhr.responseText);
            }
        };
        xhr.send(formData);
    });

    function fetchEmployees() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/employees?action=get', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                employeesTable.innerHTML = xhr.responseText;
            } else {
                alert('Error loading employees');
            }
        };
        xhr.send();
    }

    window.toggleSubordinates= function (id) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/employees?action=subordinates&id=' + id, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.status === 200) {
                    const subordinates = JSON.parse(xhr.responseText);

                    let subordinatesHtml = '';
                    subordinates.forEach(subordinate => {
                        subordinatesHtml += `<li>${subordinate.id}: ${subordinate.first_name} ${subordinate.last_name} - ${subordinate.position}</li>`;
                    });

                    document.getElementById('subordinatesList').innerHTML = subordinatesHtml;

                    document.getElementById('subordinatesModal').style.display = 'flex';
                } else {
                    alert('Error loading subordinates');
                }
            } else {
                alert('Error loading employees');
            }
        };
        xhr.send();
    }

    window.editEmployee = function (id) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/employees?action=edit&id=' + id, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const employee = JSON.parse(xhr.responseText);
                document.getElementById('modalTitle').textContent = 'Edit Employee';
                document.getElementById('id').value = employee.id;
                document.getElementById('firstName').value = employee.first_name;
                document.getElementById('lastName').value = employee.last_name;
                document.getElementById('position').value = employee.position;
                document.getElementById('email').value = employee.email;
                document.getElementById('phone').value = employee.phone;
                document.getElementById('notes').value = employee.notes;
                document.getElementById('managerId').value = employee.manager_id;
                saveEmployeeBtn.dataset.action = 'edit';
                saveEmployeeBtn.dataset.id = id;
                employeeModal.style.display = 'flex';
            }
        };
        xhr.send();
    };

    window.deleteEmployee = function (id) {
        if (confirm('Are you sure you want to delete this employee?')) {
            const xhr = new XMLHttpRequest();
            xhr.open('DELETE', '/employees?id=' + id, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', window.csrfToken);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    fetchEmployees();
                } else {
                    alert('Error deleting employee');
                }
            };
            xhr.send();
        }
    };

    document.getElementById('closeSubordinatesModal').addEventListener('click', function() {
        document.getElementById('subordinatesModal').style.display = 'none';
    });

    fetchEmployees();
});
