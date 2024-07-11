<aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
            <div>
              <img src="assets/images/logo-icon.png" class="logo-icon" style="width: 100px;">
            </div>
            <div>
              <h4 class="logo-text">WMS</h4>
            </div>
            <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i>
            </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
          
            


        

<!---------------------------------------------------------------------->
<!---------------------------------------------------------------------->
<!---------------------------------------------------------------------->
<!---------------------------------------------------------------------->
	<li>
	  <a href="/home"><div class="parent-icon"><i class="lni lni-home"></i></div>
		<div class="menu-title">Dashboard</div>
	  </a>
	</li>			

<?php 
if ((session('role')=="Accounts")||(session('role')=="Store")||(session('role')=="Super Administrator")){
?>	<li>
	  <a href="/setup"><div class="parent-icon"><i class="fadeIn animated bx bx-user"></i></div>
		<div class="menu-title">Setup</div>
	  </a>
	</li>			
<?php } ?>    
        
<?php 
if ((session('role')=="Accounts")||(session('role')=="Store")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	<li>
	  <a href="/inventory"><div class="parent-icon"><i class="fadeIn animated bx bx-user"></i></div>
		<div class="menu-title">Inventory</div>
	  </a>
	</li>			
<?php } ?>            
 
<?php if ((session('role')=="Accounts")||(session('role')=="Administrator")||(session('role')=="Super Administrator")||(session('role')=="Executive")){ ?>
	<li>
	  <a href="/account"><div class="parent-icon"><i class="fadeIn animated bx bx-user"></i></div>
		<div class="menu-title">Accounts</div>
	  </a>
	</li>			
<?php } ?>            
 
<?php if ((session('role')=="Accounts")||(session('role')=="Administrator")||(session('role')=="Super Administrator")||(session('role')=="Service Engineer")||(session('role')=="PRO")||(session('role')=="Executive")){ ?>
	<li>
	  <a href="/bill"><div class="parent-icon"><i class="fadeIn animated bx bx-user"></i></div>
		<div class="menu-title">Billing</div>
	  </a>
	</li>			
<?php } ?>    

<?php if ((session('role')=="Accounts")||(session('role')=="Store")||(session('role')=="Administrator")||(session('role')=="Super Administrator")||(session('role')=="Service Engineer")||(session('role')=="PRO")||(session('role')=="Executive")){ ?>
	<li>
	  <a href="/est"><div class="parent-icon"><i class="fadeIn animated bx bx-user"></i></div>
		<div class="menu-title">Estimate</div>
	  </a>
	</li>			
<?php } ?> 
        
<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")){ ?>
	<li>
	  <a href="/customerEdit"><div class="parent-icon"><i class="fadeIn animated bx bx-user"></i></div>
		<div class="menu-title">CRM</div>
	  </a>
	</li>			
<?php } ?> 
<?php if ((session('role')=="Accounts")||(session('role')=="Service Engineer")||(session('role')=="Administrator")||(session('role')=="PRO")||(session('role')=="Executive")||(session('role')=="Super Administrator")||(session('role')=="Store")){ ?>
	<li>
	  <a href="/ledger"><div class="parent-icon"><i class="fadeIn animated bx bx-user"></i></div>
		<div class="menu-title">Ledger</div>
	  </a>
	</li>			
<?php } ?>            
<?php if ((session('role')=="Accounts")||(session('role')=="Service Engineer")||(session('role')=="Administrator")||(session('role')=="Super Administrator")||(session('role')=="Store")||(session('role')=="PRO")||(session('role')=="Executive")){ ?>
	<li>
	  <a href="/reports"><div class="parent-icon"><i class="fadeIn animated bx bx-user"></i></div>
		<div class="menu-title">Reports</div>
	  </a>
	</li>			
<?php } ?>   

<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){ ?>
			<li class="">
              <a class="has-arrow" href="javascript:;" aria-expanded="false">
                <div class="parent-icon"><i class="bi bi-lock"></i>
                </div>
                <div class="menu-title">COA Setup</div>
              </a>
              <ul class="mm-collapse" >
                <li> <a href="/chartOfAccount01"><i class="bi bi-arrow-right-short"></i>Tree</a></li>
<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Service Engineer")){ ?>                  
                <li> <a href="/led_group"><i class="bi bi-arrow-right-short"></i>Group</a></li>
                <li> <a href="/led_subGroup01"><i class="bi bi-arrow-right-short"></i>Sub Group01</a></li>
                <li> <a href="/led_subGroup02"><i class="bi bi-arrow-right-short"></i>Sub Group02</a></li>
                <li> <a href="/led_subGroup03"><i class="bi bi-arrow-right-short"></i>Sub Group03</a></li>
                <li> <a href="/led_subGroup04"><i class="bi bi-arrow-right-short"></i>Sub Group04</a></li>
                <li> <a href="/led_subGroup05"><i class="bi bi-arrow-right-short"></i>Sub Group05</a></li>
<?php } ?>                 
              </ul>
            </li>
<?php } ?>   
            
            
            
          </ul>
          <!--end navigation-->
       </aside>