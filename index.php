<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>รายชื่อพนักงาน</title>
	<link rel="stylesheet" href="style.css" />
	
	<!--นำเข้าไฟล์  Css -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>
	
	<!--นำเข้าไฟล์  Jquery -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	
	<!--นำเข้าไฟล์  plug-in DataTable -->
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	
	<script>
			$(document).ready(function() {
				
				//คำสั่ง Javascript สำหรับเรียกใช้งาน Datatable
				$('#example').DataTable( {
					"processing": true,
					"serverSide": true,
					'serverMethod': 'post',
					"ajax": "server_processing.php",
					      'columns': [
							{ data: 'id' }, 
							{ data: 'first_name' },
							{ data: 'last_name' },
							{ data: 'email' },
							{ data: 'position' },
							{ data: 'age' },
							{ data: 'Phone' },
							{ data: 'IDLine' },
							{ data: 'Salary' },
							{ data: 'WorkExperience' },
							{ data: 'Branch' },
							{ data: 'Graduated' },
							{ data: 'Gender' },
							{ data: 'Address' },
							{ data: 'CriminalHistory' },
							{ data: 'Team' }
						]
				} );
			} );
	</script>
</head>
<body>
<header>
    <h1>รายชื่อพนักงาน</h1>
    <span><div id="real-time-clock"></div></span>
  </header>

<div id="table-scroll">
	<table id="example" class="display" style="width:100%">
        <thead>
			<tr>
				<th>ID</th>
				<th>First name</th>
				<th>Last name</th>
				<th>Email</th>
				<th>Position</th>
				<th>Age</th>
				<th>Phone</th>
				<th>ID Line</th>
				<th>Salary</th>
				<th>Work Experience(years)</th>
				<th>Branch</th>
				<th>Graduated</th>
				<th>Gender</th>
				<th>Address</th>
				<th>Criminal History</th>
				<th>Team</th>
            </tr>
        </thead>
    </table>
</div>
 <footer>
    &copy; 2025 บริษัท...... All rights reserved.
  </footer>


  <script>
function updateDateTime() {
    const clockElement = document.getElementById('real-time-clock');
    const currentTime = new Date();

    // Define arrays for days of the week and months to format the day and month names.
    const daysOfWeek = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
    const dayOfWeek = daysOfWeek[currentTime.getDay()];

    const months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    const month = months[currentTime.getMonth()];

    const day = currentTime.getDate();
    const year = currentTime.getFullYear();

    // Calculate and format hours (in 12-hour format), minutes, seconds, and AM/PM.
    let hours = currentTime.getHours();
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    const minutes = currentTime.getMinutes().toString().padStart(2, '0');
    const seconds = currentTime.getSeconds().toString().padStart(2, '0');

    // Construct the date and time string in the desired format.
    const dateTimeString = `วัน${dayOfWeek}ที่ ${day} / ${month} / ${year} เวลา: ${hours}:${minutes}`;
    clockElement.textContent = dateTimeString;
}

// Update the date and time every second (1000 milliseconds).
setInterval(updateDateTime, 1000);

// Initial update.
updateDateTime();
</script>
</body>
</html>