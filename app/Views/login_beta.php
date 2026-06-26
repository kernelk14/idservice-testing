<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    </head>

    <body>
        <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <div class="container">
            <h3 class="text-center">ID Service</h3>
            <h5 class="text-center">Login to your account</h5>

            <form action="<?= base_url('auth/authenticate') ?>" class="form">
                <?= csrf_field() ?>

                <div class="form-group container mt-lg-3 mb-lg-3 p-5 w-50 border border-dark">
                    <div class="form-outline mb-4">
                        <label for="uname" aria-label="Username">Username</label>
                        <input type="text" placeholder="Enter your username" aria-placeholder="Enter your username" class="form-control"/> 
                    </div>
                    <div class="form-outline mb-4">
                        <label for="pass" aria-label="Password">Password</label>
                        <input type="password" placeholder="Enter your password" aria-placeholder="Enter your password" class="form-control"/>
                    </div>
                    <input type="submit" value="LOGIN" class="btn btn-primary">
                </div>
            </form>
        </div>
        
    </body>
</html>