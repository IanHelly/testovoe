<?php foreach ($employees as $employee): ?>
<tr>
    <td><?php echo $employee['id']; ?></td>
    <td><?php echo $employee['first_name']; ?></td>
    <td><?php echo $employee['last_name']; ?></td>
    <td><?php echo $employee['position']; ?></td>
    <td><?php echo $employee['email']; ?></td>
    <td><?php echo $employee['phone']; ?></td>
    <td><?php echo $employee['notes']; ?></td>
    <td><?php echo $employee['manager_id']; ?></td>
    <td>
        <button class="button" onclick="editEmployee(<?php echo $employee['id']; ?>)">Edit</button>
        <button class="button delete" onclick="deleteEmployee(<?php echo $employee['id']; ?>)">Delete</button>
        <button class="button" onclick="toggleSubordinates(<?php echo $employee['id']; ?>)">Show Subordinates</button>
    </td>
</tr>
<?php endforeach; ?>
