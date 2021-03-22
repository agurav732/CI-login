<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
		
	
	
	
		<div class="col-md-12">
			<div class="page-header">
				<h1>Dashboard</h1>
			</div>
					
					<form name="update_user" id="update_user" enctype="multipart/form-data" Method="POST" action="<?= base_url().'update_user'; ?>" >
				<div class="form-group">
					<label for="first_name">First Name</label>
					<input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>" placeholder="Enter Your First Name">
					<p class="help-block">Enter Your First Name</p>
				</div>
				<div class="form-group">
					<label for="last_name">Last Name</label>
					<input type="text" class="form-control" id="last_name" name="last_name" value="<?= $last_name ?>" placeholder="Enter Your Last Name">
					<p class="help-block">Enter Your Last Name</p>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" value="<?= $email ?>"  placeholder="Enter your email">
					<p class="help-block">A valid email address</p>
				</div>
				<!-- <div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password"  value="" placeholder="Enter a password">
					<p class="help-block">At least 6 characters</p>
				</div> -->
					<div class="form-group">
					<label for="password">Department</label>
					<select  class="form-control dropdown-toggle"  name="dept" id="dept">
					<option disabled selected >Select Department</option>

					</select>
					<p class="help-block">At least 6 characters</p>
				</div>
					<div class="form-group">
					<label for="avatar1">Profile Picture</label>
				
					<input type="file" class="form-control" id="avatar1" onchange="show(this)" name="avatar"  placeholder="Enter a password">
						<img src="<?= base_url() ?>images/<?= $avatar ?>" id="avatar" style="height: 100px;
    width: 100px;">
					<p class="help-block">Only these file types are accepted :JPG PNG JPEG</p>
				</div>

			
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Register">
				</div>
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->



<SCRIPT >
  function show(input) {
        debugger;
        var validExtensions = ['jpg','png','jpeg']; //array of valid extensions
        var fileName = input.files[0].name;
        var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
        if ($.inArray(fileNameExt, validExtensions) == -1) {
            input.type = ''
            input.type = 'file'
            $('#avatar').attr('src',"");
            alert("Only these file types are accepted : "+validExtensions.join(', '));
        }
        else
        {
        if (input.files && input.files[0]) {
            var filerdr = new FileReader();
            filerdr.onload = function (e) {
                $('#avatar').attr('src', e.target.result);
            }
            filerdr.readAsDataURL(input.files[0]);
        }
        }
		
		 if (input.files && input.files[0]) {
            var reader = new FileReader();
document.getElementById("avatar").style.visibility= "visible" ;
            reader.onload = function (e) {
                $('#avatar')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(150);
					
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</SCRIPT>
<script>

		$( document ).ready(function() {

		  $.ajax({url: "dept", success: function(result){
  
	var dept_array = JSON.parse(result);

	dept_array.forEach(myFunction);

function myFunction(item, index) {
  dept_select_array= "<option value='"+item+"'>"+item+"</option>";
  $("#dept").append( dept_select_array);
}

	// console.log(myJSON);
  }});

  var select_dept = '<?= $dept ?>'; 
  setTimeout(function(){ $('#dept option[value="'+select_dept+'"]').attr("selected", "selected");}, 1000);


        });

</script>

<script>
	// $( document ).ready(function() {

	// 	   $(function () {

    //     $('#update_user').on('submit', function (e) {

    //       e.preventDefault();

    //       $.ajax({
    //         type: 'post',
    //         url: 'update_user',
    //         data: $('form').serialize(),
    //         success: function (result) {
    //           alert(result);
    //         }
    //       });

    //     });

    //   });

	// 	   });

</script>
