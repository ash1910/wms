@extends("layouts.master")

@section("content")
<main class="page-content">

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif	   

<?php
$result = DB::select("
SELECT
(SELECT COUNT(*) FROM `bill_mas` WHERE `flag`='0') draft,
(SELECT COUNT(*) FROM `bill_mas` WHERE `flag`<>'0' AND `bill_dt` LIKE '2023-%') mai,
(SELECT round(sum(`net_bill`),2) FROM `bill_mas` WHERE `flag`<>'0' AND `bill_dt` LIKE '2023-%') bill,
(SELECT round(sum(`net_bill`),2) FROM `bill_mas` WHERE `flag`='2' AND `bill_dt` LIKE '2023-%') due,
(SELECT round(sum(`amount`),2) FROM `bom_prod`)store,
(SELECT count(*) FROM `bom_prod` WHERE `stock_qty`>0) cate
from dual;
");
foreach($result as $item)
		{		
			$draft = $item->draft;
			$mai = $item->mai;
			$bill = $item->bill;
			$due = $item->due;
			$store = $item->store;
			$cate = $item->cate;
		}
?>				


            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                  </ol>
                </nav>
              </div>
            </div>



            

			<div class="row">
			
<?php 
if ((session('role')=="Accounts")||(session('role')=="Store")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){
?>
		
               <div class="col-12 col-lg-12 col-xl-12 col-xxl-6 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                      <div class="col">
                        <h5 class="mb-0">Number of Jobs</h5>
                      </div>
                      <div class="col">
                        <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer"></div>
                      </div>
                     </div>
                  </div>
					<div class="row">
					  <div class="col">
						 <div class="card">
						   <div class="card-body p-4"><div class="widget-icon mx-auto mb-3 bg-light-danger text-danger">
                      <i class="bi bi-hdd-fill"></i>
                    </div>
							  <div class="text-center">
								<h5 class="mb-0 text-orange">{{$draft}}</h5>
								<p class="mb-0 text-orange">Draft Jobs</p>
							  </div>
						   </div>
						 </div>
					  </div>
					  <div class="col">
						<div class="card">
						  <div class="card-body p-4"><div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
                      <i class="bi bi-chat-left-fill"></i>
                    </div>
							 <div class="text-center">
							   <h5 class="mb-0 text-primary">{{$mai}}</h5>
							   <p class="mb-0 text-primary">Complete Jobs [2023]</p>
							 </div>
						  </div>
						</div>
					 </div>
                    </div>                  
                </div>
               </div>
 <?php } ?>               
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){
?>	
               <div class="col-12 col-lg-12 col-xl-12 col-xxl-6 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                      <div class="col">
                        <h5 class="mb-0">Billing Status</h5>
                      </div>
                      <div class="col">
                        <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer"></div>
                      </div>
                     </div>
                  </div>
					<div class="row">
					  <div class="col">
						 <div class="card">
						   <div class="card-body p-4"><div class="widget-icon mx-auto mb-3 bg-light-success text-success">
                      <i class="bi bi-hdd-fill"></i>
                    </div>
							  <div class="text-center">
								<h5 class="mb-0 text-success">TK. {{number_format(($bill), 2, '.', ',');}}</h5>
								<p class="mb-0 text-success">Total Bill [2023]</p>
							  </div>
						   </div>
						 </div>
					  </div>
					  <div class="col">
						<div class="card">
						  <div class="card-body p-4"><div class="widget-icon mx-auto mb-3 bg-light-success text-success">
                      <i class="bi bi-hdd-fill"></i>
                    </div>
							 <div class="text-center">
							   <h5 class="mb-0 text-success">TK. {{number_format(($due), 2, '.', ',');}}</h5>
							   <p class="mb-0 text-success">Outstanding [2023]</p>
							 </div>
						  </div>
						</div>
					 </div>
                    </div>                 
                </div>
               </div>
  <?php } ?>               
<?php 
if ((session('role')=="Accounts")||(session('role')=="Store")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){
?>	
              
	
               <div class="col-12 col-lg-12 col-xl-12 col-xxl-6 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                      <div class="col">
                        <h5 class="mb-0">Inventory / Stock</h5>
                      </div>
                      <div class="col">
                        <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer"></div>
                      </div>
                     </div>
                  </div>
					<div class="row">
					  <div class="col">
						 <div class="card">
						   <div class="card-body p-4"><div class="widget-icon mx-auto mb-3 bg-light-purple text-purple">
                      <i class="bi bi-hdd-fill"></i>
                    </div>
							  <div class="text-center">
								<h5 class="mb-0 text-purple">Tk. {{number_format(($store), 2, '.', ',');}}</h5>
								<p class="mb-0 text-purple">Stock Amount</p>
							  </div>
						   </div>
						 </div>
					  </div>
					  <div class="col">
						<div class="card">
						  <div class="card-body p-4"><div class="widget-icon mx-auto mb-3 bg-light-purple text-purple">
                      <i class="bi bi-hdd-fill"></i>
                    </div>
							 <div class="text-center">
							   <h5 class="mb-0 text-purple">{{$cate}}</h5>
							   <p class="mb-0 text-purple">Product Category</p>
							 </div>
						  </div>
						</div>
					 </div>
                    </div>                   
                </div>
               </div>
  <?php } ?>               
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){
?>	
               
	
               <div class="col-12 col-lg-12 col-xl-12 col-xxl-6 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                      <div class="col">
                        <h5 class="mb-0">Number of Employee</h5>
                      </div>
                      <div class="col">
                        <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer"></div>
                      </div>
                     </div>
                  </div>
					<div class="row">
					  
					  
                    </div>                 
                </div>
               </div>
  <?php } ?>               




	
			   
               
            </div>




  
  
  
  
  
  
  
</main>  
@endsection




<?php 
if (session('role')=="Administrator1"){
?>
@section("js")
<script>
//chart4
var options = {
    series: [{
        name: "Sales: TK",
        data: [{{$JAN}}, {{$FEB}}, {{$MAR}}, {{$APR}}, {{$MAY}}, {{$JUN}}, {{$JUL}}, {{$AUG}}, {{$SEP}}, 
		{{$OCT}}, {{$NOV}}, {{$DECM}}]
    },{
        name: "Collection: TK",
        data: [{{$JAN01}}, {{$FEB01}}, {{$MAR01}}, {{$APR01}}, {{$MAY01}}, {{$JUN01}}, {{$JUL01}}, 
		{{$AUG01}}, {{$SEP01}}, {{$OCT01}}, {{$NOV01}}, {{$DECM01}}]
    }],
    chart: {
        foreColor: '#9a9797',
        type: "bar",
        //width: 130,
        height: 280,
        toolbar: {
            show: !1
        },
        zoom: {
            enabled: !1
        },
        dropShadow: {
            enabled: 0,
            top: 3,
            left: 14,
            blur: 4,
            opacity: .12,
            color: "#3361ff"
        },
        sparkline: {
            enabled: !1
        }
    },
    markers: {
        size: 0,
        colors: ["#3361ff"],
        strokeColors: "#fff",
        strokeWidth: 2,
        hover: {
            size: 7
        }
    },
    plotOptions: {
        bar: {
            horizontal: !1,
            columnWidth: "40%",
            endingShape: "rounded"
        }
    },
	legend: {
        show: false,
        position: 'top',
        horizontalAlign: 'left',
        offsetX: -20
    },
    dataLabels: {
        enabled: !1
    },
    stroke: {
        show: !0,
        width: 0,
        curve: "smooth"
    },
    fill: {
        type: 'gradient',
        gradient: {
          shade: 'light',
          type: "vertical",
          shadeIntensity: 0.5,
          gradientToColors: ["#005bea", "#12bf24"],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          //stops: [0, 50, 100],
          //colorStops: []
        }
      },
    colors: ["#348bff", "#12bf24"],
    xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    },
    tooltip: {
        theme: 'dark',
        y: {
            formatter: function (val) {
                return "" + val + ""
            }
        }
    }
  };

  var chart = new ApexCharts(document.querySelector("#chart4"), options);
  chart.render();
  
//chart2

var options = {
    series: [{{$ENG}}, {{$INT}}, {{$AUTOM}}],
    chart: {
     height: 250,
     type: 'pie',
  },
  labels: [ 'Engineering', 'Intercompany', 'Automobile'],
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'light',
      type: "vertical",
      shadeIntensity: 0.5,
      gradientToColors: ["#00c6fb", "#ff6a00", "#98ec2d"],
      inverseColors: true,
      opacityFrom: 1,
      opacityTo: 1,
      //stops: [0, 50, 100],
      //colorStops: []
    }
  },
  colors: ["#005bea", "#ee0979", "#17ad37"],
  legend: {
    show: false,
    position: 'top',
    horizontalAlign: 'left',
    offsetX: -20
  },
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        height: 270
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
  };

  var chart = new ApexCharts(document.querySelector("#chart2"), options);
  chart.render();
  
  
</script>
@endsection
<?php
}
?>