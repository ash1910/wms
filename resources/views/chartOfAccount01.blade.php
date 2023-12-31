@extends("layouts.master")

@section("content")

<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){}else { ?>
<script>window.location = "/home";</script>
<?php  }   



?>
<main class="page-content">
            <!--breadcrumb-->
	<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
	  <div class="ps-3">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb mb-0 p-0">
			<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">Dashboard </li>
			<li class="breadcrumb-item active" aria-current="page">Accounts </li>
			<li class="breadcrumb-item active" aria-current="page">Chart of Account </li>
		  </ol>
		</nav>
	  </div>
	  
	</div>
            <!--end breadcrumb-->
			
@if(session()->has('alert'))
    <div class="alert alert-success">
        {{ session()->get('alert') }}
    </div>
<script type="text/javascript">
$(document).ready(function () {
 window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
 });
</script>
@endif				
			
	<div class="card border shadow-none">
		<div class="card-header py-3">
			  <div class="row align-items-center g-3">
				<div class="col-12 col-lg-6">
				  <h5 class="mb-0">Chart of Account </h5>
				</div>
			  </div>
		</div>
	<div class="row">	
		<div class="col-12 col-lg-7">
			
			<div class="accordion-body">
<?php						  
$result = DB::select("SELECT id, name FROM `coa` WHERE `parent_id`='0';");
foreach($result as $item)
{	
	echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">&nbsp;<i class="lni lni-arrow-right-circle"></i> ';
	echo $item->name;
	echo '</div>';
	$result01 = DB::select("SELECT id, name, ledge FROM `coa` WHERE `parent_id`='$item->id';");
	foreach($result01 as $item01)
	{		
		echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href="/chartOfAccount01?id='.$item01->id.'"><i class="lni lni-pencil-alt"></i></a> ';
		echo $item01->name;
		if($item01->ledge=='1'){echo ' <span class="badge bg-primary"> P </span>';}
		echo '</div>';
		$result02 = DB::select("SELECT id, name, ledge FROM `coa` WHERE `parent_id`='$item01->id';");
		foreach($result02 as $item02)
		{		
			echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '<a href="/chartOfAccount01?id='.$item02->id.'"><i class="lni lni-pencil-alt"></i></a> ';
			echo $item02->name;
			if($item02->ledge=='1'){echo ' <span class="badge bg-primary"> P </span>';}
			echo '</div>';
			$result03 = DB::select("SELECT id, name, ledge FROM `coa` WHERE `parent_id`='$item02->id';");
			foreach($result03 as $item03)
			{		
				echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '<a href="/chartOfAccount01?id='.$item03->id.'"><i class="lni lni-pencil-alt"></i></a> ';
				echo $item03->name;
				if($item03->ledge=='1'){echo ' <span class="badge bg-primary"> P </span>';}
				echo '</div>';
				$result04 = DB::select("SELECT id, name, ledge FROM `coa` WHERE `parent_id`='$item03->id';");
				foreach($result04 as $item04)
				{		
					echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<a href="/chartOfAccount01?id='.$item04->id.'"><i class="lni lni-pencil-alt"></i></a> ';
					echo $item04->name;
					if($item04->ledge=='1'){echo ' <span class="badge bg-primary"> P </span>';}
					echo '</div>';
					$result05 = DB::select("SELECT id, name, ledge FROM `coa` WHERE `parent_id`='$item04->id';");
					foreach($result05 as $item05)
					{		
						echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<a href="/chartOfAccount01?id='.$item05->id.'"><i class="lni lni-pencil-alt"></i></a> ';
						echo $item05->name;
						if($item05->ledge=='1'){echo ' <span class="badge bg-primary"> P </span>';}
						echo '</div>';
						$result06 = DB::select("SELECT id, name, ledge FROM `coa` WHERE `parent_id`='$item05->id';");
						foreach($result06 as $item06)
						{		
							echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo '<a href="/chartOfAccount01?id='.$item06->id.'"><i class="lni lni-pencil-alt"></i></a> ';
							echo $item06->name;
							if($item06->ledge=='1'){echo ' <span class="badge bg-primary"> P </span>';}
							echo '</div>';
						}

						
					}
				}
			}
		}
	}
}

						  
?>						  
						  
			</div>
		</div>
			
			
		<div class="col-12 col-lg-5">
			<div class="">
				<?php 
				
					$id = request('id');
$data = DB::select("SELECT `name`,ledge FROM `coa` WHERE `id` = '$id'");
foreach($data as $item){ $name=$item->name ;$ledge=$item->ledge ;}					
					
					if(($id!= '') && (session('role')=="Super Administrator"))
					{?>
						
						
	<div class="card">
		<form action="setLedge" method="post">{{ csrf_field() }}
		<div class="card-body" style="background: beige;">
			<div class="input-group mb-3"> <span class="input-group-text" id="basic-addon1">Name:</span>
				<input style="background: black;color: greenyellow;" type="text" class="form-control" value="{{$name}}" readonly>
			</div>
				<div class="col-12">
                    <div class="form-check d-flex justify-content-center gap-2">
                      <input name='payment' class="form-check-input" type="checkbox" <?php if($ledge=='1'){?>checked=""<?php } ?>>
                      <label class="form-check-label" for="gridCheck3-c" required="">
                        Payment
                      </label>
                    </div>
                </div>
				<div class="col-12">
				<div class="d-grid">
				  <button type="submit" class="btn btn-primary">Set Ledge</button>
				</div>
			</div>
		</div>
		<input type="hidden" name='id' value='{{$id}}'>
		
		</form>
	</div>						



	<div class="card">
		<form action="setLedge01" method="post">{{ csrf_field() }}
		<div class="card-body" style="background: gainsboro;">
			<div class="input-group mb-3"> <span class="input-group-text" id="basic-addon1">Name:</span>
				<input style="background: black;color: greenyellow;" type="text" class="form-control" value="{{$name}}" readonly>
			</div>
            <div class="input-group mb-3"> <span class="input-group-text" id="basic-addon1">Under:</span>
				<input id="tags01" type="text" class="form-control" name="move" required>
			</div>

				<div class="col-12">
				<div class="d-grid">
				  <button type="submit" class="btn btn-primary">Move Ledge</button>
				</div>
			</div>
		</div>
		<input type="hidden" name='id' value='{{$id}}'>
		
		</form>
	</div>						



						
						
			<?php	}
				?>
					
				 
						  
			</div>
		</div>
       </div>   
    </div>
			
			
</main>



		  
@endsection		 







@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-ui.js"></script>

  
  
  
  <script>
  $( function() {
    var availableTags = [
 
  <?php
//$user_info = DB::table('user')->get(); 
$ledge = DB::select("SELECT `name` FROM `coa`");

foreach ($ledge as $p) 
{
echo '"'.$p->name.'",';
}
					   ?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 @endsection
