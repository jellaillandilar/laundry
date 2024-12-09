<?php
// Include the database connection
include 'db_connect.php';

// Fetch users from the database
$users = $conn->query("SELECT * FROM users ORDER BY username ASC");
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> New User</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card col-lg-12">
            <div class="card-body">
                <table class="table-striped table-bordered col-md-12">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through users and display them
                        $i = 1;
                        while ($row = $users->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td class="text-center"><?php echo ucfirst($row['role']); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">Action</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item edit_user" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// When the New User button is clicked, open the modal
$('#new_user').click(function(){
    uni_modal('New User', 'manage_user.php');
});

// When the Edit button is clicked, open the modal with user data
$('.edit_user').click(function(){
    uni_modal('Edit User', 'manage_user.php?id=' + $(this).attr('data-id'));
});

// When the Delete button is clicked, prompt confirmation before deleting
$('.delete_user').click(function(){
    _conf("Are you sure you want to delete this user?", "delete_user", [$(this).attr('data-id')]);
});

// Function to handle user deletion
function delete_user(id){
    start_load();  // Optional: Add a loading animation if needed
    $.ajax({
        url: 'ajax.php?action=delete_user',
        method: 'POST',
        data: {id: id},
        success: function(resp){
            if(resp == 1){
                alert_toast("Data successfully deleted", 'success');
                setTimeout(function(){
                    location.reload();  // Reload the page after deletion
                }, 1500);
            }
        }
    });
}
</script>
