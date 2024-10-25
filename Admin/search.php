<?php
require '../connection.php';

$letterID = $_GET['letterID'] ?? '';
$query = "SELECT * FROM tb_upload WHERE id LIKE '%$letterID%' ORDER BY id DESC";
$rows = mysqli_query($conn, $query);
$i = 1;
?>

<table>
  <tr class="heading">
    <td><h3>#</h3></td>
    <td class="Description"><h3>Description</h3></td>
    <td><h3>Image</h3></td>
    <td class="Approve"><h3>Approve</h3></td>
    <td class="Decline"><h3>Decline</h3></td>
    <td class="Department"><h3>Departments</h3></td>
    <td><h3>Letter ID</h3></td>
  </tr>

  <?php foreach ($rows as $row) : ?>
    <tr class="lists" data-row-id="<?php echo $row['id']; ?>">
      <td class="nlists"><?php echo $i++; ?></td>
      <td class="dlists"><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
      <td>
        <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" 
             alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" 
             title="<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>">
      </td>
      <td><h4 onclick="aproveConverter(<?php echo $row['id']; ?>)">
        <?php echo htmlspecialchars($row["Approval"], ENT_QUOTES, 'UTF-8'); ?></h4></td>
      <td><h4 onclick="declineConverter(<?php echo $row['id']; ?>)">
        <?php echo htmlspecialchars($row["Decline"], ENT_QUOTES, 'UTF-8'); ?></h4></td>
      <td>
        <h5>
          <select class="department-select" data-row-id="<?php echo $row['id']; ?>">
            <option value="ITDepartment" <?php echo $row['Departments'] === 'ITDepartment' ? 'selected' : ''; ?>>IT Department</option>
            <option value="ComputerDepartment" <?php echo $row['Departments'] === 'ComputerDepartment' ? 'selected' : ''; ?>>Computer Department</option>
            <option value="ThirdDepartment" <?php echo $row['Departments'] === 'ThirdDepartment' ? 'selected' : ''; ?>>Third Department</option>
            <option value="FourthDepartment" <?php echo $row['Departments'] === 'FourthDepartment' ? 'selected' : ''; ?>>Fourth Department</option>
            <option value="FivethDepartment" <?php echo $row['Departments'] === 'FivethDepartment' ? 'selected' : ''; ?>>Fiveth Department</option>
          </select>
        </h5>
      </td>
      <td class="nlists"><?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
  <?php endforeach; ?>
</table>
