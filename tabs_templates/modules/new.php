<?php
/* 
 NEW.PHP
 Allows user to create a new entry in the database
*/

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($username, $module_name, $error)
{
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <title>New Record</title>
    </head>
    <body>
    <?php
    // if there are any errors, display them
    if ($error != '') {
        echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
    }
    ?>

    <form action="" method="post">
        <div>
            <strong>User Name: *</strong> <input type="text" name="name" value="<?php echo $username; ?>"/><br/>
            <strong>Module Name: *</strong> <input type="text" name="module_name"
                                                   value="<?php echo $module_name; ?>"/><br/>

            <p>* required</p>
            <input type="submit" name="submit" value="Submit">
        </div>
    </form>
    </body>
    </html>
    <?php
}


// connect to the database
include('db-connect.php');

// check if the form has been submitted. If it has, start to process the form and save it to the database
if (isset($_POST['submit'])) {
    // get form data, making sure it is valid
    $username = mysql_real_escape_string(htmlspecialchars($_POST['name']));
    $module_name = mysql_real_escape_string(htmlspecialchars($_POST['module_name']));
    $getid = mysql_query("INSERT INTO modules (module_id)
		SELECT module_id FROM accounts");

    // check to make sure both fields are entered
    if ($username == '' || $module_name == '') {
        // generate error message
        $error = 'ERROR: Please fill in all required fields!';

        // if either field is blank, display the form again
        renderForm($username, $module_name, $error);
    } else {


        // save the data to the database
        mysql_query("INSERT modules SET name='$username', module_name='$module_name'")
        or die(mysql_error());


        // once saved, redirect back to the view page
        header("Location: view.php");
    }
} else // if the form hasn't been submitted, display the form
{
    renderForm('', '', '');
}
?>