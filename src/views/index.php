<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="<?php echo $_ENV["ASSETS_ROOT"]?>/assets/css/style.css">
</head>
<body>
<script>
    window.csrfToken = '<?php echo $csrf; ?>';
</script>
<div class="container">
    <h1>Employee Management System</h1>

    <button class="button" id="addEmployeeBtn">Add New Employee</button>
    <a class="button" href="/tree">Show All Tree</a>

    <table id="employeesTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Position</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Notes</th>
            <th>Manager ID</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div id="employeeModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Add Employee</h2>
            <form id="employeeForm">
                <input type="hidden" id="id" name="id">

                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" required>

                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>

                <label for="position">Position</label>
                <input type="text" id="position" name="position" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" required>

                <label for="notes">Notes</label>
                <input type="text" id="notes" name="notes">

                <label for="managerId">Manager ID</label>
                <input type="text" id="managerId" name="managerId">

                <button class="button" type="submit" id="saveEmployeeBtn">Save</button>
            </form>
            <button class="button" id="closeModalBtn">Close</button>
        </div>
    </div>

    <div id="subordinatesModal" style="display: none;">
        <div class="modal-content">
            <span id="closeSubordinatesModal" style="cursor: pointer;">&times;</span>
            <h3>Subordinates</h3>
            <ul id="subordinatesList"></ul>
        </div>
    </div>
    <script src="<?php echo $_ENV["ASSETS_ROOT"]?>/assets/js/app.js"></script>
</div>
</body>
</html>
