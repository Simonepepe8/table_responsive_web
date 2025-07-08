<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['start'])){
	
		$start = $_POST['start'];//รับข้อมูล เลขหน้าที่จะแสดง 
		
		$length = $_POST['length']; //รับข้อมูล จำนวนที่แสดงต่อหน้า ค่าเริ่มต้นคือ 10
		
		$searchData = $_POST['search']['value'];//รับข้อมูล ช่อง Search
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "employee_db";//ชื่อฐานข้อมูล

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		
		// Check connection
		if (!$conn) {
		  die("Connection failed: " . mysqli_connect_error());
		}

		$searchValueResult = "";
		
		$searchValueData = mysqli_real_escape_string($conn,$searchData); // Search value
		
		//Query กรณีมีการค้นหาข้อมูล
		if($searchValueData != ''){
		   $searchValueResult = " WHERE first_name LIKE '%".$searchValueData."%'  OR last_name LIKE '%".$searchValueData."%' OR email LIKE '%".$searchValueData."%' ";
		}
		
		//Query นับจำนวนข้อมูลทั้งหมด
		$t = mysqli_query($conn,"SELECT COUNT(*) as total FROM datatable");
		$records = mysqli_fetch_assoc($t);
		$totalRecords = $records['total'];

		//Query นับจำนวนข้อมูลที่ค้นหาเจอ
		if($searchValueData != ''){
		    $f = mysqli_query($conn,"SELECT COUNT(*) as total FROM datatable $searchValueResult");
		    $filteredRecords = mysqli_fetch_assoc($f);
		    $totalFiltered = $filteredRecords['total'];
		} else {
		    $totalFiltered = $totalRecords;
		}

		// รับข้อมูลการ sort จาก DataTables
		$orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
		$orderDir = isset($_POST['order'][0]['dir']) && in_array($_POST['order'][0]['dir'], ['asc','desc']) ? $_POST['order'][0]['dir'] : 'asc';

		// กำหนด mapping index ของคอลัมน์ให้ตรงกับ columns ใน DataTables
		$columns = [
			'id', 
		    'first_name',
		    'last_name',
		    'email',
		    'position',
		    'age',
		    'Phone',
		    'IDLine',
		    'Salary',
		    'WorkExperience',
		    'Branch',
		    'Graduated',
		    'Gender',
		    'Address',
		    'CriminalHistory',
		    'Team'
		];

		// ตรวจสอบ index ไม่เกินจำนวนคอลัมน์
		$orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : $columns[0];

		// เพิ่ม ORDER BY ใน SQL
		if ($orderColumn == 'WorkExperience') {
		    $orderSql = " ORDER BY CAST(WorkExperience AS UNSIGNED) $orderDir ";
		} else {
		    $orderSql = " ORDER BY $orderColumn $orderDir ";
		}

		//Query ข้อมูลที่จะแสดงใน DataTable
		$sql = "SELECT * FROM datatable $searchValueResult $orderSql LIMIT $start , $length";
		$result = mysqli_query($conn, $sql);
		
		$data = array();

		if (mysqli_num_rows($result) > 0) {

		  while($row = mysqli_fetch_assoc($result)) {

			    $data[] = array(
					'id' => $row['id'], 
					'first_name'=> $row['first_name'],
					'last_name'=> $row['last_name'],
					'email'=> $row['email'],
                    'position'=> $row['position'],
                    'age'=> $row['age'],
					'Phone'=> $row['Phone'],
					'IDLine'=> $row['IDLine'],
					'Salary'=> $row['Salary'],
					'WorkExperience'=> $row['WorkExperience'],
					'Branch'=> $row['Branch'],
					'Graduated'=> $row['Graduated'],
					'Gender'=> $row['Gender'],
					'Address'=> $row['Address'],
					'CriminalHistory'=> $row['CriminalHistory'],
					'Team'=> $row['Team']
				);
		  }
		}

		mysqli_close($conn);

		$json_data = array(
			"draw"            => intval( $_REQUEST['draw'] ),   
			"recordsTotal"    => intval($totalRecords ),  
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data   // total data array
		);

		echo json_encode($json_data);
	
}


?>