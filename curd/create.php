
<?php
include_once "./user.php";
$users= User::all ();
$errors =[];

if(isset($_POST['Create']))
{ 
    $errors = validate($_POST,['name','email','password']);
    if(count($errors)<=0)
    {
        $dataCreate = [
            'name' =>$_POST['name'],
            'email' =>$_POST['email'],
            'password' =>md5($_POST['password']),
        ];
        $userCreate = user::Create($dataCreate);
        $_SESSION['message']= "Create success";
        $errors=[];
        header("location:./index.php");
    }
}else{
    $errors =[];
}
//var_dump($errors)
?>
<!doctype html>
<html lang="en">
  <head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Create User</title>
  </head>
  <body>
    <div class="container">
        <div>
            <h1>Create User</h1>
        </div>
        <div>
            <form method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" name="email" class="form-control"id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="text-danger">
                    <?php echo isset($errors['email']) ? $errors['email'] :"" ?>
                </div>
                
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Name</label>
                <input type="text"name="name" class="form-control" >
                <div class="text-danger">
                    <?php echo isset($errors['name']) ? $errors['name'] :"" ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password"class="form-control" id="exampleInputPassword1">
                <div class="text-danger">
                    <?php echo isset($errors['password']) ? $errors['password'] :"" ?>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" name="Create">Create</button>
            </form>
        </div>
       
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>