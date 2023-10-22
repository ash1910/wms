@extends("layouts.master")

@section("content")

<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){}else { ?>
<script>window.location = "/home";</script>
<?php  }   ?>


<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Account </li>
                    <li class="breadcrumb-item active" aria-current="page">Day End </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
	<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">

	<form class="row g-3" action="dayEnd01" method='post'>
	{{ csrf_field() }}
	<div class="col-12">
		<div class="col-md-12">
			<label class="form-label">Date:</label>
			<select name="dt" class="form-select mb-3" required="" autofocus>
									
<?php
$data = DB::select("SELECT DATE_ADD(`date`, INTERVAL 1 DAY) AS next_day FROM `day_end` ORDER by 1 DESC;");
foreach($data as $item){   ?>
<option value="{{$item->next_day}}">{{date('d-M-Y', strtotime($item->next_day))}}</option>
<?php } ?>
			</select>
		</div>
	</div>
		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="lni lni-files"></i> Generate DayEnd</button>
		</div>
	</form>

</div>
	</div></div>
</div>
			
			
</main>



		  
@endsection		 