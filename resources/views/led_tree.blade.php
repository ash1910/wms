@extends("layouts.master")

@section("content")



<main class="page-content">





		<div class="col-xl-6 mx-auto">
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">Ledger Tree</h6>
                <hr>
                
<?php				
$data01 = DB::select("SELECT `id`,`name` FROM `led_master`");
foreach($data01 as $item01)
{ 
	echo $item01->id.'-'.$item01->name.'</br>' ;
	$data02 = DB::select("SELECT `id`,`name` FROM `led_group` where `master_id` = '$item01->id'");
	foreach($data02 as $item02)
	{ 
		echo '&emsp;&emsp;&emsp;'.$item02->id.'-'.$item02->name.'</br>' ;
		$data03 = DB::select("SELECT `id`,`name` FROM `led_sub` where `master_id` = '$item01->id' and group_id = '$item02->id'");
		foreach($data03 as $item03)
		{ 
			echo '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'.$item03->id.'-'.$item03->name.'</br>' ;
			$data04 = DB::select("SELECT `id`,`name` FROM `led_ledger` 
			where `master_id` = '$item01->id' and group_id = '$item02->id' and sub_id = '$item03->id'");
			foreach($data04 as $item04)
			{ 
			echo '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'.$item04->id.'-'.$item04->name.'</br>' ;
			
			}

		}

		
		
		
	}

}				
?>				
				
              </div>
              </div>
            </div>
		</div>



  
</main>  
@endsection






@section("js")


  
 @endsection