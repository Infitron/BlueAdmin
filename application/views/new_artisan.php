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
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Forms</a></li>
                            <li class="active">Basic</li>
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
            <div class="col-lg-6">
                <form action="<?php echo base_url(); ?>addArtisan" method="POST">
                    <div class="card">
                        <div class="card-header"><strong>Artsan</strong><small> Form</small></div>
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="company" class=" form-control-label">First Name</label>
                                <input type="text" id="company" placeholder="First Name" class="form-control" name="FirstName">
                                <input type="hidden" name="UserId" value="<?php echo $this->session->userdata('userId');?>">
                            </div>
                            <input type="hidden" id="country" value="string" name="PicturePath">
                            
                            <div class="form-group">
                                <label for="vat" class=" form-control-label">Last Name</label>
                                <input type="text" id="vat" placeholder="Last Name" class="form-control" name="LastName">
                            </div>
                                    
                            <div class="form-group">
                                <label for="street" class=" form-control-label">Phone Number</label>
                                <input type="text" id="street" placeholder="Phone Number" class="form-control" name="PhoneNumber">
                            </div>
                                    
                            <div class="row form-group">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="city" class=" form-control-label">City</label>
                                        <select class="form-control" name="AreaLocationId">
                                            <option value="1">Yaba</option>
                                            <option value="12">Agege</option>
                                            <option value="3">Surulere</option>
                                            <option value="4">Ifako</option>
                                            <option value="5">Ikeja</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="postal-code" class=" form-control-label">Identity Code</label>
                                        <input type="text" id="postal-code" placeholder="Identity Code" class="form-control" name="IdcardNo">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country" class=" form-control-label">Address</label>
                                <input type="text" id="country" placeholder="Address" class="form-control" name="Address">
                            </div>
                            <div class="row form-group">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="city" class=" form-control-label">Category</label>
                                        <select class="form-control" name="ArtisanCategoryId">
                                            <option value="1">Auto</option>
                                            <option value="2">Electronic</option>
                                            <option value="3">Fabrication</option>
                                            <option value="4">Fashions</option>
                                            <option value="5">Homes and Office</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="postal-code" class=" form-control-label">State</label>
                                        <select class="form-control" name="State">
                                            <option value="Lagos">Lagos</option>
                                            <option value="Oyo">Oyo</option>
                                            <option value="Ogun">Ogun</option>
                                            <option value="Imo">Imo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country" class=" form-control-label">About Me</label>
                                <input type="text" id="country" placeholder="About me" class="form-control" name="AboutMe">
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="submit" name="submit" value="Add Artisan" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>