<div class="card">
    <div class="card-header">
        <h2>Login</h2>
    </div>
    <div class="card-body">
        <?php
//        TODO: remove duplicate code from here and instead of use include
//        include '../components/message.php';
        if(isset($errors) && count($errors) > 0) {
            foreach($errors as $error_msg) {
                echo '<div class="alert alert-danger" role="alert">'.$error_msg.'</div>';
            }
        }
        if(isset($success)) {
            echo '<div class="alert alert-success" role="alert">'.$success.'</div>';
        }
        ?>
        <form action="/account/signin" method="post" id="login_form">
            <div>
                <div class="form-group">
                    <label for="my-name">Login</label>
                    <input type="text" name="login" class="login_input" placeholder="Login" id="my-name" required />
                </div>
                <div class="form-group">
                    <label for="my-password">Password</label>
                    <input type="password" name="password" class="login_input" placeholder="Password" id="my-password" required />
                </div>
                <div class="form-group">
                    <input name="submit" type="submit" value="Login" class="btn btn-success login_input_submit" />
                </div>
            </div>
        </form>
    </div>
</div>