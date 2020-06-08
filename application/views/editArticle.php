<?php
        
    
    $id = '';
    $title = '';
    $articleBody = '';
    $approvalStatus = '';
    $userName = '';

    if(!empty($message))
    {
        foreach ($message as $uf)
        {
            $id = $uf['id'];
            $title = $uf['title'];
            $articleBody = $uf['articleBody'];
            $approvalStatus = $uf['approvalStatus'];
            $userName = $uf['userName'];
        }
    }

    //print_r($uf);
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
                            <li><a href="<?php echo base_url(); ?>articles">All Article</a></li>
                            <li class="active">Article</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <strong>Update  Article</strong> Details
                    </div>
                    <div class="card-body card-block">
                        <form action="<?php echo base_url() ?>updateArticle" method="post" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Article Title</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="text-input" name="title" placeholder="Title" class="form-control" value="<?php echo $title; ?>">
                                    <input type="hidden" value="<?php echo $id; ?>" name="id" id="id" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Username</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="text-input" class="form-control" value="<?php echo $userName; ?>" readonly>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Article Status</label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <select name="ApprovalStatusId" id="ApprovalStatusId" class="form-control">
                                        <option value="<?php echo $approvalStatus; ?>"><?php echo $approvalStatus; ?></option>
                                        <option value="2">Approved</option>
                                        <option value="8">Submitted</option>
                                        <option value="3">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="email-input" class=" form-control-label">Artical Content</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <textarea name="articleBody" id="textarea-input" rows="9" placeholder="" class="form-control"><?php echo $articleBody; ?></textarea>
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