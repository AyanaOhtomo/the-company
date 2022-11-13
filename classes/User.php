<?php 
require_once "Datebase.php";

class User extends Database{
    public function store($request)
    {
        $first_name = $request["first_Name"];
        $last_name = $request["last_Name"];
        $username = $request["username"];
        $password = $request["password"];


        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` (`first_name`, `last_name`, `username`, `password`) VALUES ('$first_name','$last_name','$username','$password')";

        if($this->conn->query($sql)) {
            header("location:../views");
            exit;
        }else {
            die("Error creating the user:" . $this->conn->error);
        }
    }

    public function login($request)
    {
        $username = $request['username'];
        $password = $request["password"];

        $sql = "SELECT * FROM `users` WHERE `username` = '$username'";

        $result = $this->conn->query($sql);

        // chack the username
        if($result->num_rows == 1){
            //change the format to an associativ array

            //get date inport to $user
            $user = $result->fetch_assoc();

            //chack if the password is correct
            if(password_verify($password,$user['password'])){
                //create session varialble for future use
                session_start();

                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['first_name'] . " " .$user['last_name'];

                header("location: ../views/dashboard.php");
                exit;

            }else {
                die("password is INcorrect.");
            }

        }else {
            die("Username Not Foound ." );
        }
    }

    public function getAllUsers(){
        $sql = "SELECT `id` , `first_name` ,`last_name` , `username` , `photo` FROM `users`";

        //if sql is success
        if($result = $this->conn->query($sql)){
            return $result;
        }else {
            die("Error retrieving all users:" . $this->conn->error);
        }

    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("location: ../views");
        exit;
    }

    public function getUser()
    {
        $id = $_SESSION['id'];

        $sql = "SELECT  `first_name`, `last_name`, `username`, `photo` FROM `users` WHERE `id` = $id";

        //if sql is success
        if($result = $this->conn->query($sql)){
            return $result->fetch_assoc();

        }else{
            die("Error retriving the user:" . $this->conn->error);
        }
    }

    public function update($request,$files) // $request = $_POST  $files = $_FILES
    {
        session_start();

        $id = $_SESSION['id'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $username = $request['username'];
        $photo = $files['photo']['name'];
        $tmp_photo = $files['photo']['tmp_name'];

        $sql = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `username` = '$username'
                WHERE `id` = $id";

        //if sql is success
        if($this->conn->query($sql)){
            $_SESSION['username'] = "$username";
            $_SESSION['full_name'] = "$first_name $last_name";

            //If there is an uploaded photo, save it to DB & save the file to images folder
            if ($photo) {
                $sql = "UPDATE `users` SET `photo` = '$photo' WHERE `id` = $id";
                $destination = "../assets/images/$photo";

                // Save the image name to db
                if($this->conn->query($sql)){
                    // Save the uploaded photo to the images folder
                    if(move_uploaded_file($tmp_photo, $destination)){
                        header("location: ../views/dashboard.php");
                        exit;
                    }else{
                        die("Error moving the photo.");
                    }
                }else{
                    die("Error uploading photo: " . $this->conn->error);
                }

            }

            header("location: ../views/dashboard.php");
            exit;

        }else{
            die("Error updating your account:" .$this->conn->error );

        }


    }

    public function dalete(){
        session_start();
        $id = $_SESSION['id'];

        $sql = "DELETE FROM `users` WHERE `id` = $id";
        if($this->conn->query($sql)){
            $this->logout();

        }else {
            die("Error daleting your account:" .$this->conn->error );
        }

    }


}

?>