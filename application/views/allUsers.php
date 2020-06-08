<?php

    $curl = curl_init();

    //$token = $this->session->userdata('token');

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.bluecollarhub.com.ng/api/Account/AllUserLogin",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 60,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/json",
        "authorization: Bearer ".$this->session->userdata('token')
      ),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl))
    {
        print "Error: " . curl_error($curl);
    }
    else
    {
        // Show me the result

        $transaction = json_decode($response, TRUE);

        curl_close($curl);
    }
            
    $message = $transaction['message'];
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
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Users</a></li>
                            <li class="active">All User</li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">All User</strong>
                        <a href="<?php echo base_url() ?>export_users" target="_blank" class="btn btn-success btn-flat"><i class="fa fa-send"></i>&nbsp;Export Excel</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($message))
                                    {
                                        $i=1;
                                        foreach($message as $record)
                                        {
                                    ?>
                                      <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?= $record['username'] ?></td>
                                        <td><?= $record['userRole'] ?></td>
                                        <td><?= $record['emailAddress'] ?></td>
                                        <td><?= $record['status'] ?></td>
                                        <td class="text-center">
                                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editUser/'.$record['userId']; ?>" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                          </a>
                                          <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="" title="Delete">
                                            <i class="fa fa-trash"></i>
                                          </a>
                                        </td>
                                      </tr>
                                      <?php
                                        $i++;
                                        }
                                    }
                                ?>   
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->