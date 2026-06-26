<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ID Requests</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css')?>">
        <link rel="shortcut icon" href="<?= base_url('favicon-16x16.png') ?>" type="image/x-icon">
    </head>
    <body>
                                <!-- NAVBAR IMPLEMENTATION -->
        <div class="navbar navbar-expand-lg" style="background-color: #800000;">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto">
                    <a href="#" class="navbar-brand ms-2">
                        <img src="<?= base_url('logo-web.png') ?>" width="32" height="32">
                    </a>
                    <li class="navbar-text">
                        <span class="text-light align-items-center align-content-center d-flex me-2">
                            Hello!,&nbsp;
                                <b><?= strtoupper(auth()->user()->username) ?></b>&nbsp; <!-- Displays your username -->
                                (<b><?= strtoupper(auth()->user()->getGroups()[0]) ?></b>) <!-- Displays your user status -->
                        </span>
                    </li>
                    <li class="navbar-text me-2 text-light"><span>|</span></li>
                    <li class="navbar-text me-2 text-light">
                        <h5>List of Requests</h5>
                    </li>
                </ul>
                <button type="submit" class="btn btn-primary" id="actionBtn" style="display: none;" form="processForm">Process Selected</button>
                &nbsp;
                <a href="<?= base_url('requests/create') ?>" class="btn btn-success">Insert ID Request</a>
                &nbsp;
                <a href="<?= base_url('requests/process') ?>" class="btn btn-info text-white">Queues</a>
                &nbsp;
                <a href="<?= base_url('admin/logout') ?>" class="btn btn-secondary">Log out</a>
            </div>
        </div>
                                <!-- END OF NAVBAR IMPLEMENTATION -->

                                <!-- CONTENT IMPLEMENTATION -->
        <form method="POST" action="<?= base_url('requests/process') ?>" id="processForm">
        <div class="container-fluid">
            <div class="container">
        
                <?php if(session() && session()->getFlashdata('message')): ?>
                    <p class="text-success"><?= session()->getFlashdata('message') ?></p>
                <?php endif; ?>
                </div>    
            
            <div class="container-fluid mt-lg-4">

                <?php if(!empty($users)): ?>
                    <table class="table table-secondary text-center align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>
                                    <div class="form-check ms-3">
                                        <input type="checkbox" class="form-check-input" id="selectAllUsers">
                                    </div>
                                </th>
                                <th>Request No.</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Emergency Contact</th>
                                <th>Emergency Contact Number</th>
                                <th>Image Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $u): ?>
                                <tr>
                                    <td>
                                        <div class="form-check ms-3">
                                            <input type="checkbox" 
                                                name="userIds[]"  
                                                class="form-check-input row-checkbox"
                                                id="check"
                                                autocomplete="off"
                                                value="<?= $u['userId'] ?>"
                                            />
                                        </div>
                                    </td>
                                    <td><?= $u['userId'] ?></td>
                                    <td><?= $u['name'] ?></td>
                                    <td><?= $u['email'] ?></td>
                                    <td><?= $u['address'] ?></td>
                                    <td><?= $u['contact_num'] ?></td>
                                    <td><?= $u['emergency_person'] ?></td>
                                    <td><?= $u['emergency_number'] ?></td>
                                    <td><img src="<?= base_url('uploads/' . $u['attach_id']) ?>" 
                                             width="64" 
                                             height="64"
                                        />
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No users found. <a href="<?= base_url('user/create') ?>">Create one</a></p>
                <?php endif; ?>
            </div>
        </div>
        </form>
                                <!-- END OF CONTENT IMPLEMENTATION -->

        <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= base_url('assets/control.js') ?>"></script>
        <script>
            document.getElementById('selectAllUsers').addEventListener('change', function() {
                document.querySelectorAll('.row-checkbox').forEach(cb => {
                    cb.checked = this.checked;
                    cb.dispatchEvent(new Event('change'));
                });
            });
        </script>        
    </body>
</html>