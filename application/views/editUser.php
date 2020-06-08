<?php
        
    
    $userId = '';
    $username = '';
    $userRole = '';
    $emailAddress = '';
    $status = '';

    if(!empty($message))
    {
        foreach ($message as $uf)
        {
            $userId = $uf['userId'];
            $username = $uf['username'];
            $userRole = $uf['userRole'];
            $emailAddress = $uf['emailAddress'];
            $status = $uf['status'];
        }
    }

    //print_r($message);
    //exit();


?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="<?php echo base_url(); ?>dashboard">Dashboard</a></li>
                            <li><a href="<?php echo base_url(); ?>allUsers">All Users</a></li>
                            <li class="active">User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <?php $this->load->helper('form'); ?>
            <div class="row">
                <div class="col-md-12">
                  <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
            </div>
            <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
                if($error)
                {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error; ?>
            </div>
            <?php }
                $success = $this->session->flashdata('success');
                if($success)
                {
            ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $success; ?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <strong>Update  User</strong> Details
                    </div>
                    <div class="card-body card-block">
                        <form action="<?php echo base_url() ?>updateUser" method="POST" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Username</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="text-input" name="username" value="<?php echo $username; ?>" class="form-control">
                                    <input type="hidden" value="<?php echo $userId; ?>" name="UserId" id="UserId" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="email-input" class=" form-control-label">Email</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="email" id="email-input" name="emailAddress" value="<?php echo $emailAddress; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Role</label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <select id="userRole" class="form-control" name="userRole">
                                        <option value="<?php echo $userRole; ?>"><?php echo $userRole; ?></option>
                                        <option value="1">Artisan</option>
                                        <option value="2">Client</option>
                                        <option value="3">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Status</label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <select id="StatusId" class="form-control" name="StatusId">
                                        <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                        <option value="4">Active</option>
                                        <option value="10">Suspend</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions form-group">
                                <input type="submit" class="btn btn-primary btn-sm" value="Update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->