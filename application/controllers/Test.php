<?php
defined('BASEPATH') OR exit('No direct script access allowed');


function action()
	{
	  	if($this->input->post('data_action'))
	  	{
	   		$data_action = $this->input->post('data_action');

		   if($data_action == "Delete")
		   {
			    $api_url = "http://localhost/tutorial/codeigniter/api/delete";

			    $form_data = array(
			     'id'  => $this->input->post('user_id')
			    );

			    $client = curl_init($api_url);

			    curl_setopt($client, CURLOPT_POST, true);

			    curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

			    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

			    $response = curl_exec($client);

			    curl_close($client);

			    echo $response;
			}

	   		if($data_action == "Edit")
		   	{
			    $api_url = "http://localhost/tutorial/codeigniter/api/update";

			    $form_data = array(
			     'first_name'  => $this->input->post('first_name'),
			     'last_name'   => $this->input->post('last_name'),
			     'id'    => $this->input->post('user_id')
			    );

			    $client = curl_init($api_url);

			    curl_setopt($client, CURLOPT_POST, true);

			    curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

			    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

			    $response = curl_exec($client);

			    curl_close($client);

			    echo $response;
		    }

		   	if($data_action == "fetch_single")
		   	{
			    $api_url = "http://localhost/tutorial/codeigniter/api/fetch_single";

			    $form_data = array(
			     'id'  => $this->input->post('user_id')
			    );

			    $client = curl_init($api_url);

			    curl_setopt($client, CURLOPT_POST, true);

			    curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

			    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

			    $response = curl_exec($client);

			    curl_close($client);

			    echo $response;
		   	}

		   	if($data_action == "Insert")
		   	{
			    $api_url = "http://localhost/tutorial/codeigniter/api/insert";
			   

			    $form_data = array(
			     'first_name'  => $this->input->post('first_name'),
			     'last_name'   => $this->input->post('last_name')
			    );

			    $client = curl_init($api_url);

			    curl_setopt($client, CURLOPT_POST, true);

			    curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

			    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

			    $response = curl_exec($client);

			    curl_close($client);

			    echo $response;
		   	}


		   	if($data_action == "fetch_all")
		   	{
			    $api_url = "http://api.bluecollarhub.com.ng/api/Account/AllUserLogin";

			    $client = curl_init($api_url);

			    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

			    $response = curl_exec($client);

			    curl_close($client);

			    $result = json_decode($response);

			    $output = '';

			    if(count($result) > 0)
			    {
			     	foreach($result as $row)
				    {
				      $output .= '
				      <tr>
				       <td>'.$row->first_name.'</td>
				       <td>'.$row->last_name.'</td>
				       <td><butto type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->id.'">Edit</button></td>
				       <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->id.'">Delete</button></td>
				      </tr>

				      ';
				    }
			    }
			    else
			    {
			     	$output .= '
			     	<tr>
			      	<td colspan="4" align="center">No Data Found</td>
			     	</tr>
			     	';
			    }

		    	echo $output;
		   	}
	  	}
	}




	<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    
    function fetch_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>test_api/action",
            method:"POST",
            data:{data_action:'fetch_all'},
            success:function(data)
            {
                $('tbody').html(data);
            }
        });
    }

    fetch_data();

    $('#add_button').click(function(){
        $('#user_form')[0].reset();
        $('.modal-title').text("Add User");
        $('#action').val('Add');
        $('#data_action').val("Insert");
        $('#userModal').modal('show');
    });

    $(document).on('submit', '#user_form', function(event){
        event.preventDefault();
        $.ajax({
            url:"<?php echo base_url() . 'test_api/action' ?>",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                if(data.success)
                {
                    $('#user_form')[0].reset();
                    $('#userModal').modal('hide');
                    fetch_data();
                    if($('#data_action').val() == "Insert")
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Inserted</div>');
                    }
                }

                if(data.error)
                {
                    $('#first_name_error').html(data.first_name_error);
                    $('#last_name_error').html(data.last_name_error);
                }
            }
        })
    });
    

    $(document).on('click', '.edit', function(){
        var user_id = $(this).attr('id');
        $.ajax({
            url:"<?php echo base_url(); ?>test_api/action",
            method:"POST",
            data:{user_id:user_id, data_action:'fetch_single'},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('.modal-title').text('Edit User');
                $('#user_id').val(user_id);
                $('#action').val('Edit');
                $('#data_action').val('Edit');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var user_id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?"))
        {
            $.ajax({
                url:"<?php echo base_url(); ?>test_api/action",
                method:"POST",
                data:{user_id:user_id, data_action:'Delete'},
                dataType:"JSON",
                success:function(data)
                {
                    if(data.success)
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Deleted</div>');
                        fetch_data();
                    }
                }
            })
        }
    });
    
});
</script>