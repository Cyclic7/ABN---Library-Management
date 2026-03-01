<?php include '../../includes/header.php'; ?>
<div class="container">
    <h2>Register New Member</h2>
    <form action="insert_member.php" method="POST">
        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Phone Number</label>
        <input type="text" name="phone">

        <label>Membership Type</label>
        <select name="type">
            <option value="Student">Student</option>
            <option value="Faculty">Faculty</option>
            <option value="Guest">Guest</option>
        </select>

        <button type="submit" class="btn btn-add">Register Member</button>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>