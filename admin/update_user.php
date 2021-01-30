<?php
// core configuration
include_once "../config/core.php";

// make it work in PHP 5.4
include_once "../libs/php/pw-hashing/passwordLib.php";

// check if logged in as admin
//include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../objects/user.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$user = new User($db);

// set page title
$page_title = "<a href='read_users.php'>Users</a> / Edit User";

// include page header HTML
include_once "layout_head.php";

echo "<div class='col-md-12'>";

	// get user id on the URL parameter
	$user_id=isset($_GET['id']) ? $_GET['id'] : die('Missing user ID.');

	// if HTML form was submitted / posted
	if($_POST){

		// set posted values to user properties
		$user->surname=$_POST['firstname'];
		$user->oname=$_POST['lastname'];
		$user->email=$_POST['email'];
		$user->telephone=$_POST['contact_number'];
		$user->password=$_POST['password'];
		$user->status=1;
		$user->group_id=$_POST['group_id'];

		$email= $_POST['email'];
		$user->id=$user_id;

		// update the user
		if($user->update()){

			// get currently logged in user first name
			$user->id=$_SESSION['user_id'];
			$user->readOne();

			// change saved firstname
			$_SESSION['surname']=$user->surname;

			// tell the user it was updated
			echo "<div class='alert alert-success'>User was edited</div>";
		}

		// unable to edit user
		else{
			echo "<div class='alert alert-danger' role='alert'>Unable to edit user.</div>";
		}
	}

	// set user id property
	$user->id=$user_id;

	// read user details
	$user->readOne();
	?>

	<!-- HTML form to update user -->
	<form action='update_user.php?id=<?php echo $user_id; ?>' method='post' id='update-user'>

	    <table class='table table-hover table-responsive table-bordered'>

	        <tr>
	            <td class='width-30-percent'>Firstname</td>
	            <td><input type='text' name='firstname' value="<?php echo $user->firstname; ?>" class='form-control' required></td>
	        </tr>

	        <tr>
	            <td>Lastname</td>
	            <td><input type='text' name='lastname' value="<?php echo $user->lastname; ?>" class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Contact Number</td>
	            <td><input type='text' name='contact_number' value="<?php echo $user->contact_number; ?>" class='form-control' required></td>
	        </tr>

			

			<?php
			// if it is the first admin user, access level is automatically 'Admin'
			if($user_id==1||$user_id==4){
				echo "<input type='hidden' name='access_level' value='Admin' />";
			}

			// else there's the choice, either the user will be 'Admin' or 'Customer'
			else{
			?>

			<tr>
	            <td>Access Level</td>
	            <td>
					<div class="btn-group" data-toggle="buttons">

						<!-- highlight the correct access level button -->
						<label class="btn btn-default <?php echo $user->group_id=='1' ? 'active' : ''; ?>">
							<input type="radio" name="group_id" value="1" <?php echo $user->group_id=='1' ? 'checked' : ''; ?>> Dashboard User
						</label>

						<label class="btn btn-default <?php echo $user->group_id=='2' ? 'active' : ''; ?>">
							<input type="radio" name="group_id" value="2" <?php echo $user->group_id=='2' ? 'checked' : ''; ?>> Facility User
						</label>
						<label class="btn btn-default <?php echo $user->group_id=='3' ? 'active' : ''; ?>">
							<input type="radio" name="group_id" value="3" <?php echo $user->group_id=='3' ? 'checked' : ''; ?>> State User
						</label>

						<label class="btn btn-default <?php echo $user->group_id=='4' ? 'active' : ''; ?>">
							<input type="radio" name="group_id" value="4" <?php echo $user->group_id=='4' ? 'checked' : ''; ?>> Admin
						</label>

					</div>
				</td>
	        </tr>

			<?php
			}
			?>

			<tr>
	            <td>Email</td>
	            <td><input type='email' name='email' value="<?php echo $user->email; ?>" class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Password</td>
	            <td><input type='text' name='password' value="<?php echo $user->password; ?>" class='form-control' required></td>
	        </tr>
			
	        <tr>
	            <td></td>
	            <td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Edit User
					</button>
	            </td>
	        </tr>

	    </table>
	</form>

<?php
echo "</div>";

// include page footer HTML
include_once "layout_foot.php";
?>
