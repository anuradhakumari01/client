<?php
include('connection.php');
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>window.open('login.php','_self');</script>";
} else {

    $user_qry = mysqli_query($con, "SELECT * FROM `user` WHERE `username` ='" . $_SESSION['username'] . "' and `role` ='" . $_SESSION['role'] . "' ");
    if (mysqli_num_rows($user_qry) > 0) {
        $row = mysqli_fetch_assoc($user_qry);
        $uid = $row['user_id'];
        $role = $row['role'];
       
    }
?>
    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Register</title>
        <style>

        </style>
    </head>
<?php ?>
    <body>
        <h6 class="text-right p-3"><a href="logout.php">Logout</a></h6>
        <div class="container">
            <h4 class="text-right">Welcome <span style="color:blue;font-size:18px"><?php echo $_SESSION['username']; ?></span></h4>
            <p class="text-right"><?php if ($role == 0) {
                                        echo "Client";
                                    } else {
                                        echo "Product Manager";
                                    } ?></p>
        </div>

        <?php if(isset($_POST['commentsubmit'])){
              extract($_POST);   
              
              $articleupdate = mysqli_query($con, "UPDATE `article` SET `comment`='$comment',`u_id`='$comment_userid' where `article_id`='$article_id'");
                    
            }?>
        <?php if ($role == 0) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Article ID</th>
                        <th scope="col">Try Here</th>
                        <th scope="col">Current Status</th>
                        <th scope="col">Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $article = mysqli_query($con, "SELECT * FROM `article`  ORDER BY article_id DESC");
                    $count = 1;
                    while ($articles = mysqli_fetch_assoc($article)) {
                    ?>
                        <tr>

                            <td><?php echo $articles['article_id']; ?></td>
                            <td><a href="<?php echo $articles['tryhere']; ?>"><?php echo $articles['tryhere']; ?> </a></td>
                            <td> <select onchange="testMessage(<?php echo  $articles['article_id']; ?>)" class="form-control" id="exampleFormControlSelect<?php echo  $articles['article_id']; ?>">
                                    <option <?php if ($articles['current_status'] == 1) {
                                                echo "selected";
                                            } ?> value="1">YES</option>
                                    <option <?php if ($articles['current_status'] == 0) {
                                                echo "selected" ;
                                            } ?> value="0">NO</option>
                                </select></td>
                                <div class="modal fade" id="exampleModalCenter<?php echo  $articles['article_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Comments add</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Comment</label>
                                                        <input type="text" name="comment" class="form-control" id="comment"   placeholder="Enter Comment">
                                                    </div>
                                                    <input type="hidden" name="comment_userid" value="<?php echo $uid ; ?>">
                                                    <input type="hidden" name="article_id" value="<?php echo $articles['article_id']; ?>">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary"  name="commentsubmit">OK</button>
                                                    </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <td><?php echo $articles['comment']; ?></td>
                        </tr>
                    <?php $count++;
                    } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Article ID</th>
                        <th scope="col">Current Status</th>
                        <th scope="col">Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $article_qry = mysqli_query($con, "SELECT * FROM article");
                    $count = 1;
                    while ($user_articles = mysqli_fetch_assoc($article_qry)) {
                    ?>
                        <tr>
                            <td><?php echo $user_articles['u_id']; ?></td>
                            <td><?php echo $user_articles['article_id']; ?></td>
                            <td>
                                <select class="form-control" id="exampleFormControlSelect1" name="status">
                                    <option <?php if ($user_articles['current_status'] == 1) {
                                                echo "selected";
                                            } ?> value="1">YES</option>
                                    <option <?php if ($user_articles['current_status'] == 0) {
                                                echo "selected";
                                            } ?> value="0">NO</option>
                                </select>
                               
                            </td>
                            <td><?php echo $user_articles['comment']; ?></td>
                        </tr>
                    <?php $count++;
                    } ?>
                </tbody>
            </table>

        <?php } ?>

    
        <script type="text/javascript">
    function testMessage(x){
        var s="#exampleModalCenter"+x;
        $(s).modal('show');
    }
</script>
    

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script>

</script>
    </body>


    </html>
<?php } ?>