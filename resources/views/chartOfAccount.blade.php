@extends("layouts.master")

@section("content")



<main class="page-content">

			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item active" aria-current="page">Chart of Account</li>
                  </ol>
                </nav>
              </div>
              
            </div>



		<div class="col-xl-6 mx-auto">
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">Chart of Account</h6>
                <hr>
   


   
<?php		
\DB::statement("SET SQL_MODE=''");//this is the trick use it just before your query		

$result = DB::select("
SELECT
\"N/A\" AS parent,
g1.`name`, 
IFNULL(SUM(CASE WHEN t.txtype='C' THEN t.`amount` ELSE -(t.`amount`) END), 0) balance 
FROM `groups` AS g1 
LEFT JOIN `groups` AS g2 ON g2.parent_id = g1.id 
LEFT JOIN `groups` AS g3 ON g3.parent_id = g2.id 
LEFT JOIN `groups` AS g4 ON g4.parent_id = g3.id 
LEFT JOIN `accounts` AS a ON g4.`id`=a.`groups_id` 
LEFT JOIN `transactions` AS t ON a.id=t.`accounts_id` 
WHERE g1.`parent_id` IS NULL AND g1.`name` IS NOT NULL 
GROUP BY g1.`name`
UNION
SELECT
g1.`name` AS parent,
g2.`name`, 
IFNULL(SUM(CASE WHEN t.txtype='C' THEN t.`amount` ELSE -(t.`amount`) END), 0) balance 
FROM `groups` AS g1 
LEFT JOIN `groups` AS g2 ON g2.parent_id = g1.id 
LEFT JOIN `groups` AS g3 ON g3.parent_id = g2.id 
LEFT JOIN `groups` AS g4 ON g4.parent_id = g3.id 
LEFT JOIN `accounts` AS a ON g4.`id`=a.`groups_id` 
LEFT JOIN `transactions` AS t ON a.id=t.`accounts_id` 
WHERE g1.`parent_id` IS NULL AND g2.`name` IS NOT NULL
GROUP BY 
g2.`name`
UNION
SELECT
g2.`name` AS parent,
g3.`name`, 
IFNULL(SUM(CASE WHEN t.txtype='C' THEN t.`amount` ELSE -(t.`amount`) END), 0) balance 
FROM `groups` AS g1 
LEFT JOIN `groups` AS g2 ON g2.parent_id = g1.id 
LEFT JOIN `groups` AS g3 ON g3.parent_id = g2.id 
LEFT JOIN `groups` AS g4 ON g4.parent_id = g3.id 
LEFT JOIN `accounts` AS a ON g4.`id`=a.`groups_id` 
LEFT JOIN `transactions` AS t ON a.id=t.`accounts_id` 
WHERE g1.`parent_id` IS NULL AND g3.`name` IS NOT NULL 
GROUP BY 
g3.`name`
UNION
SELECT
g3.`name` AS parent,
g4.`name`, 
IFNULL(SUM(CASE WHEN t.txtype='C' THEN t.`amount` ELSE -(t.`amount`) END), 0) balance 
FROM `groups` AS g1 
LEFT JOIN `groups` AS g2 ON g2.parent_id = g1.id 
LEFT JOIN `groups` AS g3 ON g3.parent_id = g2.id 
LEFT JOIN `groups` AS g4 ON g4.parent_id = g3.id 
LEFT JOIN `accounts` AS a ON g4.`id`=a.`groups_id` 
LEFT JOIN `transactions` AS t ON a.id=t.`accounts_id` 
WHERE g1.`parent_id` IS NULL AND g4.`name` IS NOT NULL 
GROUP BY 
g4.`name`
UNION
SELECT
g4.`name` AS parent, 
a.`name`, 
IFNULL(SUM(CASE WHEN t.txtype='C' THEN t.`amount` ELSE -(t.`amount`) END), 0) balance 
FROM `groups` AS g1 
LEFT JOIN `groups` AS g2 ON g2.parent_id = g1.id 
LEFT JOIN `groups` AS g3 ON g3.parent_id = g2.id 
LEFT JOIN `groups` AS g4 ON g4.parent_id = g3.id 
LEFT JOIN `accounts` AS a ON g4.`id`=a.`groups_id` 
LEFT JOIN `transactions` AS t ON a.id=t.`accounts_id` 
WHERE g1.`parent_id` IS NULL AND a.`name` IS NOT NULL 
GROUP BY a.`name`");



// read each row
$rows = [];
foreach($result as $row)
{
    $rows[] = (array) $row;
}

// Generate the chart of accounts tree view
echo generateAccountTree("N/A", $rows);

// Function to recursively generate a nested list of accounts
function generateAccountTree($parent, $result) {
    $finalresult = '<ul>';
    foreach ($result as $account) {
        if ($account['parent'] == $parent) {
            $finalresult .= '<li>' . $account['name'] . ">> " .$account['balance'];
            $finalresult .= generateAccountTree($account['name'], $result);
            $finalresult .= '</li>';
        }
    }
    $finalresult .= '</ul>';
    return $finalresult;
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