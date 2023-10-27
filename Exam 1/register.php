<?php
session_start();
// echo var_dump($_POST);
if(isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['image']) && isset($_POST['type']) && isset($_POST['upw']) && isset($_POST['cupw'])) {
    $un = $_POST['uname'];
    $em = $_POST['email'];
    $img = $_POST['img'];
    $ut = $_POST['type'];
    $pw = $_POST['upw'];
    $cpw = $_POST['cupw'];

    $all_errors= [];
    $allowed_ext=['png', 'jpg', 'jpeg'];
    $flag = 0 ;
    
    // Username Validation


    if(!empty($un)) {
        if(strlen($un) >= 5 && strlen($un) <= 20) {
            if(preg_match('@[A-Z][a-z][0-9]@', $un)  && preg_replace('/\s+/', '',$un)) {
                
                $flag++;// 1

            } else {
                $all_errors['un_senior'] = 'Username can only contain letters, numbers, and underscores';
            }
        } else {
            $all_errors['un_length'] = 'Username must be between 5 and 20 characters long.';
        }
    } else {
        $all_errors['un_empty'] = 'Username cannot be empty.';
    }

    // Email Validation

    if(!empty($em)) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
                $flag++;// 2

            } else {
                $all_errors['em_format'] = 'Invalid email format.';
            }
    
    } else {
        $all_errors['em_empty'] = 'Email cannot be empty.';
    }


    // Profile_image Validation
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_FILES['$img'])){
            if($_FILES['$img']['error'] =0){

                $my_img = $_FILES['$img'];
                $img_tmp = $my_img['tmp']; 
                $img_size = $my_img['size']; 
                $img_name = uniqid() . $my_img['name'];
                $img_ext = explode(".", $img_name);
                $img_ext_end = end($img_ext);
                $ext = strtolower($img_ext_end);
                    if($img_size < 1572864){
                        if(in_array($ext, $allowed_ext)){

                            move_uploaded_file($img_tmp, 'uploads/profile/' . $img_name);
                            $flag++; //3
                        }else{
                            $all_errors['img']['f_ext'] = "Invalid image type. Only JPEG, PNG, and JPG are allowed.";
                        }

                    }else{
                    $all_errors['img']['f_size'] = 'Maximum File Size Must Be 1.5MB';
                    }

            }else{
                $all_errors['img']['f_exist'] = 'Error uploading image.';
            }
        }
    }

    // Role Validation

    if(! empty($type)){

        $flag++; //4

    }else{

        $all_errors['type_empty'] = 'Must Check on Role cannot be empty.';
    }

    // Password Validation

    if(!empty($pw)) {
        if(strlen($pw) >= 8) {
            if(preg_match('@[A-Z][a-z]@', $pw)) {
                $flag++ ; //5
            } else {
                $all_errors['pw_alpha'] = 'Password can only contain letters, numbers, and underscores.';
            }
        } else {
            $all_errors['pw_length'] = 'Password must be at least 8 characters long.';
        }
    } else {
        $all_errors['pw_empty'] = 'Password cannot be empty.';
    }


    // Confirm Password Validation

    if($pw == $cpw){

        $flag++;    //6

    }else{
        $all_errors['pw_empty'] = 'Passwords do not match';
    }
    

    if(empty($all_errors) && $flag == 6) {
        
        $_SESSION['register'] = [$un, $em, $img, $ut, $pw, $cpw];
         
        header('location:login.php');
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Design by foolishdeveloper.com -->
    <title>Glassmorphism login Form Tutorial in html css</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->

    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #080710;
        }

        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(#1845ad,
                    #23a2f6);
            left: -80px;
            top: 40%;
        }

        .shape:last-child {
            background: linear-gradient(to right,
                    #ff512f,
                    #f09819);
            right: -30px;
            bottom: -65%;
        }

        form {
            margin-top: 300px;
            margin-bottom: 300px;
            height: fit-content;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            margin-top: 50px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        .social {
            margin-top: 30px;
            display: flex;
        }

        .social div {
            background: red;
            width: 150px;
            border-radius: 3px;
            padding: 5px 10px 10px 5px;
            background-color: rgba(255, 255, 255, 0.27);
            color: #eaf0fb;
            text-align: center;
        }

        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }

        .social .fb {
            margin-left: 25px;
        }

        .social i {
            margin-right: 4px;
        }

        input[type=radio] {
            height: 25px;
            width: 25px;
            display: inline-block;
        }

        .spn-radio {
            padding: 5px;
            font-size: 20px;
            color: #EB901A;
        }
    </style>

</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <h3>Register Here</h3>

        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
            <symbol id="check-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
            <symbol id="info-fill" viewBox="0 0 16 16">
                <path
                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </symbol>
            <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </symbol>
        </svg>
        <?php if(! empty($all_errors)):?>
            <?php foreach($all_errors as $error):?>

                <?= $error?>

            <?php endforeach?>  
        <?php endif?>
        <label for="username">Username</label>
        <input type="text" placeholder="username" id="username" name="uname">


        <label for="email">Email</label>
        <input type="text" placeholder="email" id="email" name="email">


        <label for="img">Profile Image</label>
        <input type="file" id="img" name="img">


        <label for="username">User Type</label>
        <input type="radio" name="type" value="a"><span class="spn-radio">Admin</span>
        <input type="radio" name="type" value="u"><span class="spn-radio">User</span>


        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="upw">


        <label for="co-password">confirm Password</label>
        <input type="password" placeholder="Confirm Password" id="co-password" name="cupw">


        <button>Register</button>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Register </div>
        </div>
    </form>
</body>

</html>