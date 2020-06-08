<?php

$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api.bluecollarhub.com.ng/api/v1/Order",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$this->session->userdata('token')
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
            $order = json_decode($response, TRUE);

            curl_close($curl);
        }
        $data = $order['message'];


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
                            <li><a href="#">Booking</a></li>
                            <li class="active">All Booking</li>
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
                        <strong class="card-title">All Booking</strong>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Client Name</th>
                                    <th>Service</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($data))
                                    {
                                        $i=1;
                                        foreach($data as $record)
                                        {
                                    ?>
                                      <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?= $record['artisanFullName'] ?></td>
                                        <td><?= $record['clientFullName'] ?></td>
                                        <td><?= $record['messages'] ?></td>
                                        <td><?= date('M j, Y', strtotime($record['msgDate'])); ?></td>
                                        
                                        <td class="text-center">
                                          <a class="btn btn-sm btn-info" href="#" title="Edit">
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
                                    else
                                    {
                                        echo "<p>Reefreh Page<p/>";
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