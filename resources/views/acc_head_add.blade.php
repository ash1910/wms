<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" ></script>

@extends("layouts.master")

@section("content")




<?php 

$myID = request()->get('id');

//echo ($myID);

if(isset($myID)){

  $dt_AccHead_Edit = DB::table('tbl_acc_masters')->select('id','acc_name')->where('id', '=', $myID)->first();

  $dt_AccGroup_Edit = DB::table('tbl_acc_masters')->select('id','child_name','grp_under')->where('id', '=', $myID)->first();

}


$dt_AccGroup = DB::select("SELECT * FROM `tbl_acc_masters` WHERE id > 5 AND grp_status ='GR'ORDER BY acc_name;");


?>







<main class="page-content">



{{-- Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('success')}}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('warning')}}
    </div>
@endif

			
  
            <div class="row">			
                        
                    <div class="col-12 col-lg-6">
                        <div class="card shadow-none border">
                            <div class="card-body">
                              

                                <div class="table-responsive">    <!-- Div stat -->
                                
                                        <div class="card" >
                                            <a class="btn btn-success" href="/acc_head_list"><i class="fadeIn animated bx bx-add-to-queue"></i> List of Accounts Head</a>
                                        </div>
                                     
                                                                                
                                        <div class="card"  style="padding:20px"> 
                                                    <div class="card">
                                                <div class="card-body">
                                                    <div class="border p-3 rounded">
                                                    <h6 class="mb-0 text-uppercase">Add Accounts Head </h6>
                                                    <hr>
                                                                                                        
                                                    <form class="row g-3" action="{{url('acc_head_add')}}" method="post">{{ csrf_field() }}

                                                        @if(isset( $dt_AccHead_Edit )) 
                                                        <input  type="hidden" name="acc_id" id="acc_id" value="{{$_GET['id']}}">
                                                        @endif

                                                        <div class="col-12">
                                                        <label class="form-label">Accounts Name</label>
                                                        <input  autofocus type="text" name="a_name" id="a_name" placeholder="" type="text" class="form-control" 
                                                        @if(isset( $dt_AccHead_Edit )) value="{{$dt_AccHead_Edit->acc_name}}" @else value=""  @endif 
                                                        required maxlength="50">
                                                        
                                                        </div>

                                                        <div class="col-12">
                                                        <label class="form-label">Under Group</label>
                                                            <div class="select">
                                                            <select name="under_group" id="under_group" class="form-select mb-3" required>  
                                                                @if(isset( $dt_AccGroup_Edit )) 
                                                                <option  value="{{$dt_AccGroup_Edit->grp_under}} {{'|'}} {{$dt_AccGroup_Edit->child_name}}" >{{$dt_AccGroup_Edit->child_name}} </option>
                                                                @endif   

                                                                @if(isset( $dt_AccGroup ))
                                                                        @foreach ( $dt_AccGroup as $group)
                                                                        <option  value="{{$group->id}} {{'|'}} {{$group->acc_name}}" >{{$group->acc_name}} </option>
                                                                        @endforeach
                                                                @endif
                                                                

                                                            </select>    
                                                        </div>  
                                                        </div>

                                                        <div class="col-12">
                                                        <label class="form-label">A/C Config</label>
                                                            <select name="acc_config" id="acc_config"  class="form-select form-select-sm"> 
                                                            
                                                                <option value="No"> No </option>
                                                                <option value="Card Charges"> Card Charges </option>
                                                            
                                                            </select> 
                                                        </div>   




                                                        <div class="col-12">
                                                        <div class="d-grid">
                                                            @if(isset( $dt_AccGroup_Edit )) 
                                                            <button type="submit" class="btn btn-primary">Update </button>
                                                            @else
                                                            <button type="submit" class="btn btn-primary">Create</button>
                                                            @endif
                                                            
                                                        </div>
                                                        </div>

                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                
                                </div>  <!-- Div End -->
                            </div>
                        </div>
                    </div>	



                    <div class="col-12 col-lg-6">
                        <div class="card shadow-none border">
                            <div class="card-body">
                                <div class="table-responsive">    <!-- Div stat -->

                               
			
			
<?php						  
$result = DB::select("SELECT id, acc_name FROM `tbl_acc_masters` WHERE `grp_under`='0' and acc_name <> 'Primary';");
foreach($result as $item)
{	
	echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">&nbsp;<i class="lni lni-arrow-right-circle"></i> ';
	echo $item->acc_name;
	echo '</div>';
	$result01 = DB::select("SELECT id, acc_name, grp_status FROM `tbl_acc_masters` WHERE `grp_under`='$item->id';");
	foreach($result01 as $item01)
	{		
		echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a><i class="bi bi-folder"></i></a> ';
		echo $item01->acc_name;
		if($item01->grp_status=='AH'){echo ' <span class="badge bg-primary"> P </span>';}
		echo '</div>';
		$result02 = DB::select("SELECT id, acc_name, grp_status FROM `tbl_acc_masters` WHERE `grp_under`='$item01->id';");
		foreach($result02 as $item02)
		{		
			echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            if($item02->grp_status=='GR'){echo '<a><i class="bi bi-folder"></i></a> ';} 
            if($item02->grp_status=='AH'){echo ' <span class="badge bg-primary"> A </span>';}
			echo $item02->acc_name;
			echo '</div>';
			$result03 = DB::select("SELECT id, acc_name, grp_status FROM `tbl_acc_masters` WHERE `grp_under`='$item02->id';");
            foreach($result03 as $item03)
			{		
				echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                if($item03->grp_status=='GR'){echo '<a><i class="bi bi-folder"></i></a> ';} 
                if($item03->grp_status=='AH'){echo ' <span class="badge bg-primary"> A </span>';}
                echo $item03->acc_name;
                echo '</div>';
				$result04 = DB::select("SELECT id, acc_name, grp_status FROM `tbl_acc_masters` WHERE `grp_under`='$item03->id';");
                foreach($result04 as $item04)
                {		
                    echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    if($item04->grp_status=='GR'){echo '<a><i class="bi bi-folder"></i></a> ';} 
                    if($item04->grp_status=='AH'){echo ' <span class="badge bg-primary"> A </span>';}
                    echo $item04->acc_name;
                    echo '</div>';
                    $result05 = DB::select("SELECT id, acc_name, grp_status FROM `tbl_acc_masters` WHERE `grp_under`='$item04->id';");
                    foreach($result05 as $item05)
                    {		
                        echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        if($item05->grp_status=='GR'){echo '<a><i class="bi bi-folder"></i></a> ';} 
                        if($item05->grp_status=='AH'){echo ' <span class="badge bg-primary"> A </span>';}
                        echo $item05->acc_name;
                        echo '</div>';
                        $result06 = DB::select("SELECT id, acc_name, grp_status FROM `tbl_acc_masters` WHERE `grp_under`='$item05->id';");
                        
                            $result06 = DB::select("SELECT id, acc_name, grp_status FROM `tbl_acc_masters` WHERE `grp_under`='$item05->id';");
                            foreach($result06 as $item06)
                            {		
                                echo '<div style="border: 1px solid rgba(0, 0, 0, 0.44);">';
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                if($item06->grp_status=='GR'){echo '<a><i class="bi bi-folder"></i></a> ';} 
                                if($item06->grp_status=='AH'){echo ' <span class="badge bg-primary"> A </span>';}
                                echo $item06->acc_name;
                                echo '</div>';
                                $result07 = DB::select("SELECT id, acc_name, grp_status FROM `tbl_acc_masters` WHERE `grp_under`='$item06->id';");
                                
                            }
                    }
                    
                }
				
			}
			
		}
	}
}

						  
?>						
				



                        
                                        
                                
                                </div> <!-- Div End -->
                              				
                            </div>

                        </div>
                    </div>
                    		
            </div>			
			
			
			
			
			
			
			



			
</main>
@endsection		 





@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-3.6.0.js"></script>
  <script src="assets/js/jquery-ui.js"></script>
 
 @endsection
