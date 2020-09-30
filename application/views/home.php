
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <style>
      .active1{
        background-color: #555;
        color:#fff;
      }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <center><h1>CRUD - <small>Codeigniter Database</small></h1></center>
        </div>
        <div class="messages"></div>
         <a href="#" data-toggle="modal" data-target="#model" id="add" class="btn btn-primary"> + Add</a>
         <a href="#" id="edit" data-toggle="modal" data-target=""  class="btn btn-success">^ Edit</a>
         <a href="#" id="view" class="btn btn-warning"  data-toggle="modal" data-target="">^ View</a>
         <a href="#" id="delete" class="btn btn-danger">- delete</a>
		
        <table class="table table-bordered" id="manageMemberTable">
			<thead>
				<tr>
            <th>id</th>       
          <th>Name</th>
          
					<th>Age</th>
					<th>Contact</th>
					<th>Address</th>
					
				</tr>
			</thead>
		</table>
        
    <div class="modal fade" tabindex="-1" role="dialog" id="model">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Member</h4>
      </div>
      <form method="post" action="<?php echo base_url() ?>Welcome/create" id="createForm">
      <div class="modal-body"> 
        
          <input type="text" id="id" name="id" hidden>
         
			  <div class="form-group">
			    <label for="fname">First Name * </label>
			    <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
			  </div>
			  <div class="form-group">
			    <label for="lname">Last Name</label>
			    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
			  </div>	
			  <div class="form-group">
			    <label for="age">Age * </label>
			    <input type="text" class="form-control" id="age" name="age" placeholder="Age">
			  </div>	
			  <div class="form-group">
			    <label for="contact">Contact * </label>
			    <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact">
			  </div>	
			  <div class="form-group">
			    <label for="address">Address</label>
			    <input type="text" class="form-control" id="address" name="address" placeholder="Address">
			  </div>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save-btn">Add user</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script>
 $('document').ready(function(){
  var rowData;
  var table = $('#manageMemberTable').DataTable({
    'ajax': 'welcome/fetchMemberData',
	  'orders': [],
   
    
        
  
  });
  $('#manageMemberTable tbody' ).on('click','tr',function(){
      rowData= table.row(this).data()
      
      if($('tr').hasClass('active1')){
        $('tr').removeClass('active1')
      }
      else{
        $(this).addClass('active1')
      }
      
        
       
      
        
      
     
  })
  $('#add').click(function(e){
      e.preventDefault()
      $('#createForm')[0].reset()
       $('#createForm').on('submit',function(e){
           e.preventDefault();
           var form=$(this)
           $('#save-btn').html('sending...')

           $.ajax({
               url:form.attr('action'),
               type:form.attr('method'),
               data:form.serialize(),
               dataType:'json',
               success:function(response){
                 
                   if(response.success===true){
                    $("#addMember").modal('hide');
                   $(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                    '</div>');
                    table.ajax.reload()
                    $('#createForm')[0].reset()
                    $('#save-btn').html('Add user')

                   }
                   else{
                       if(response.messages instanceof Object){
                          $.each(response.messages,function(index,value){
                             var id=$("#"+index)
                               id
                               .closest('.form-group')
                               .removeClass('has-error')
							                 .removeClass('has-success')
                               .addClass(value.length > 0 ? 'has-error' : 'has-success')
                               .after(value);


                          })
                       }
                       else{
                        $("#addMember").modal('hide');
                        $(".messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
						'</div>');
                       }
                   }
                   
               }
           })
       })
      
  })
  //edit
  $('#edit').click(function(e){
   e.preventDefault()
   if(rowData==undefined){
     
     
   }
   else{
   $(this).attr('data-target','#model')
   $('#save-btn').html('Edit user')
   var name=rowData[1].split(' ')
   $('#id').val(rowData[0])
   $('#fname').val(name[0])
   $('#lname').val(name[1])
   $('#age').val(rowData[2])
   $('#contact').val(rowData[3])
   $('#address').val(rowData[4])

   $('#createForm').on('submit',function(e){
     e.preventDefault()
      var form=$(this)

      $.ajax({
               url:'Welcome/update',
               type:form.attr('method'),
               data:form.serialize(),
               dataType:'json',
               success:function(response){
                
                 if(response.success==true){
                  $("#model").modal('hide');
                   $(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                    '</div>');
                    table.ajax.reload()
                    $('#createForm')[0].reset()
                   

                 }
                 else{
                   if(response.messages instanceof Object){
                     $.each(response.messages,function(index,value){
                      var id=$("#"+index)
                               id
                               .closest('.form-group')
                               .removeClass('has-error')
							                 .removeClass('has-success')
                               .addClass(value.length > 0 ? 'has-error' : 'has-success')
                               .after(value);

                     })
                   }
                 }
               }
      })
   })
 
   }
   
  
  })
  $('#view').click(function(e){
    e.preventDefault()
    if(rowData==undefined){
     
     
    }
    else{
      $(this).attr('data-target','#model')
      $('.modal-footer').css('display','none')
      var name=rowData[1].split(' ')
      $('#id').val(rowData[0])
      $('#fname').val(name[0])
      $('#lname').val(name[1])
      $('#age').val(rowData[2])
      $('#contact').val(rowData[3])
      $('#address').val(rowData[4])

    }
  })
  $('#delete').click(function(e){
   e.preventDefault()
   if(rowData==undefined){
     
     confirm('you have not selected record')
     
    }
    else{
      confirm('Do you need to delete this record')
      $.ajax({
        url:'Welcome/delete/'+rowData[0],
        type:'POST',
        dataType:'json',
        success:function(response){
         if(response.success==true){
            table.ajax.reload()
            $(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                    '</div>');
         }

        }

       
      })
    }
  })
 })


</script>
</body>
</html>