
  // Ensure DOM is fully loaded before executing the code
  document.addEventListener('DOMContentLoaded', function() {
    // Change Set Functionality
    const setLinks = document.getElementsByClassName("navSet");
    const setLists = document.getElementsByClassName("setLists");
  
    // Change Set Function Definition
    window.changeSet = function(nameSet) { // Attach to window object
      for (let setLink of setLinks) {
        setLink.classList.remove("active");
      }
      for (let setList of setLists) {
        setList.classList.remove("activeSet");
      }
      event.currentTarget.classList.add("active");
      document.getElementById(nameSet).classList.add("activeSet");
    };
// Ensure DOM is fully loaded before executing the code
  // Toggle Declined Messages Table
  const toggleButton = document.getElementById('toggleButton');
  if (toggleButton) {
    toggleButton.addEventListener('click', function (event) {
      event.preventDefault();
      const tableBox = document.getElementById('declinedMessagesTable');
      tableBox.style.display = (tableBox.style.display === 'none' || tableBox.style.display === '') 
        ? 'block' 
        : 'none';
    });
  }

  // Restore Record Function
  window.restoreRecord = function(id) {
    if (confirm('Are you sure you want to restore this record?')) {
      fetch(`restoreRecord.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Record restored successfully!');
            location.reload();
          } else {
            alert('Failed to restore the record.');
          }
        })
        .catch(error => console.error('Error:', error));
    }
  };

  // Toggle New Messages Table
  const toggleNewButton = document.getElementById('toggleNewButton');
  if (toggleNewButton) {
    toggleNewButton.addEventListener('click', function (event) {
      event.preventDefault();
      const newTable = document.getElementById('NewMessagesTable');
      newTable.style.display = (newTable.style.display === 'none' || newTable.style.display === '') 
        ? 'block' 
        : 'none';
    });
  }

  // Toggle Accepted Messages Table
  const toggleAcceptedButton = document.getElementById('toggleAcceptedButton');
  if (toggleAcceptedButton) {
    toggleAcceptedButton.addEventListener('click', function (event) {
      event.preventDefault();
      const acceptedTable = document.getElementById('acceptedMessagesTable');
      acceptedTable.style.display = (acceptedTable.style.display === 'none' || acceptedTable.style.display === '') 
        ? 'block' 
        : 'none';
    });
  }

  // Toggle Rejected Messages Table
  const toggleRejectedButton = document.getElementById('toggleRejectedButton');
  if (toggleRejectedButton) {
    toggleRejectedButton.addEventListener('click', function (event) {
      event.preventDefault();
      const rejectedTable = document.getElementById('RegectedMessagesTable');
      rejectedTable.style.display = (rejectedTable.style.display === 'none' || rejectedTable.style.display === '') 
        ? 'block' 
        : 'none';
    });
  }

  // Toggle Approved Messages Table
  const toggleApproveButton = document.getElementById('toggleApproveButton');
  if (toggleApproveButton) {
    toggleApproveButton.addEventListener('click', function (event) {
      event.preventDefault();
      const approvedTable = document.getElementById('approvedMessagesTable');
      approvedTable.style.display = (approvedTable.style.display === 'none' || approvedTable.style.display === '') 
        ? 'block' 
        : 'none';
    });
  }

  // system admin unique code edit
  const toggleEdit = document.getElementById('toggle-edit');
  if (toggleEdit) {
    toggleEdit.addEventListener('click', function (event) {
      event.preventDefault();
      const approvedTable = document.getElementById('toggle-edit-div');
      approvedTable.style.display = (approvedTable.style.display === 'none' || approvedTable.style.display === '') 
        ? 'block' 
        : 'none';
    });
  }

  // Search by Letter ID
  window.searchByLetterID = function(searchValue) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `search.php?letterID=${searchValue}`, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        document.getElementById("tableBox").innerHTML = xhr.responseText;
      }
    };
    xhr.send();
  };


  // Toggle Restore Status
  window.toggleRestoreStatus = function(rowId) {
    const restoreElement = document.querySelector(`[data-restore-id="${rowId}"]`);
    const currentStatus = restoreElement.textContent.trim();
    const newStatus = currentStatus === 'OFF' ? 'ON' : 'OFF';

    restoreElement.textContent = newStatus;
    restoreElement.classList.toggle('on-status', newStatus === 'ON');
    restoreElement.classList.toggle('off-status', newStatus === 'OFF');

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_restore_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(`id=${rowId}&restore=${newStatus}`);
  };
 
  // IT Department Toggle Restore
  window.ITtoggleRestore = function(rowId) {
    if (confirm('Are you sure you want to Delete this Message?')) {
      const restoreElement = document.querySelector(`[data-restore-id="${rowId}"]`);
      const currentStatus = restoreElement.textContent.trim();
      const newStatus = currentStatus === 'OFF' ? 'ON' : 'OFF';

      restoreElement.textContent = newStatus;
      restoreElement.classList.toggle('on-status', newStatus === 'ON');
      restoreElement.classList.toggle('off-status', newStatus === 'OFF');

      const xhr = new XMLHttpRequest();
      xhr.open("POST", "update_decline.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send(`id=${rowId}&Decline=${newStatus}`);
    }
  };

  // IT Department Toggle Restore Status for Deleted Messages
  window.ITtoggleRestoreStatus = function(rowId) {
    const restoreElement = document.querySelector(`[data-restore-id="${rowId}"]`);
    const currentStatus = restoreElement.textContent.trim();
    const newStatus = currentStatus === 'OFF' ? 'ON' : 'OFF';

    restoreElement.textContent = newStatus;
    restoreElement.classList.toggle('on-status', newStatus === 'ON');
    restoreElement.classList.toggle('off-status', newStatus === 'OFF');

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ITMessageRestore.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(`id=${rowId}&restore=${newStatus}`);
  };

  // delete status
  window.toggleDeleteStatus = function(rowId, rowPassword) {
    if (confirm('Are you sure you want to Delete this Admin?')) {
    const deleteElement = document.querySelector(`[data-delete-username="${rowId}"]`);
    if (!deleteElement) return;

    const currentStatus = deleteElement.textContent.trim();
    const newStatus = currentStatus === 'OFF' ? 'ON' : 'OFF';

    deleteElement.textContent = newStatus;
    deleteElement.classList.toggle('on-status', newStatus === 'ON');
    deleteElement.classList.toggle('off-status', newStatus === 'OFF');

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./deleteforSystemAdmin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(`username=${encodeURIComponent(rowId)}&password=${encodeURIComponent(rowPassword)}&deleted=${newStatus}`);

    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          console.log("Server response:", xhr.responseText); 
          alert(xhr.responseText); 
        } else {
          console.error("Failed to update delete status:", xhr.status, xhr.statusText);
        }
      }
    };
   }
  };


  // IT toggle Departments Approved
  window.ITtoggleApproveStatus = function(rowId) {
    const approveElement = document.querySelector(`[data-Approve-id="${rowId}"]`);
    const currentStatus = approveElement.textContent.trim();
    const newStatus = currentStatus === 'OFF' ? 'ON' : 'OFF';

    approveElement.textContent = newStatus;
    approveElement.classList.toggle('on-status', newStatus === 'ON');
    approveElement.classList.toggle('off-status', newStatus === 'OFF');

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ITMessageApprove.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Sending correct key-value pair
    xhr.send(`id=${rowId}&Approval=${newStatus}`);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // For debugging
        } else if (xhr.readyState === 4) {
            console.error("Error updating status");
        }
    };
  };

  window.RecordOfficerAcceptedSendMessage = function(rowId) {
    const sendElement = document.querySelector(`[data-Send-id="${rowId}"]`);
    const currentStatus = sendElement.textContent.trim();
    const newStatus = currentStatus === 'OFF' ? 'ON' : 'OFF';

    sendElement.textContent = newStatus;
    sendElement.classList.toggle('on-status', newStatus === 'ON');
    sendElement.classList.toggle('off-status', newStatus === 'OFF');

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "AcceptedMessage.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send with the correct key
    xhr.send(`id=${rowId}&send=${newStatus}`);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log(xhr.responseText); // Debugging response
            } else {
                console.error("Error updating status");
            }
        }
    };
};


});

// the rejected restore and decline table
function toggleStatus(element, field, apiUrl) {
  const rowId = element.getAttribute(`data-${field}-id`);
  const currentStatus = element.textContent.trim();
  const newStatus = currentStatus === 'OFF' ? 'ON' : 'OFF';

  // Update UI
  element.textContent = newStatus;
  element.classList.toggle('on-status', newStatus === 'ON');
  element.classList.toggle('off-status', newStatus === 'OFF');

  // Send AJAX request
  const xhr = new XMLHttpRequest();
  xhr.open("POST", apiUrl, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(`id=${rowId}&${field}=${newStatus}`);
}

// Add Event Listeners for Restore and Decline Columns
document.querySelectorAll('.toggle-restore').forEach(function (element) {
  element.addEventListener('click', function () {
      toggleStatus(element, 'restore', 'updatedRejectedRestore.php');
  });
});

document.querySelectorAll('.toggle-decline').forEach(function (element) {
  element.addEventListener('click', function () {
      toggleStatus(element, 'decline', 'updatedRejectedDecline.php');
  });
});

// it new message sub button
const toggleNewITButton = document.getElementById('itNewMessages');
  if (toggleNewITButton) {
    toggleNewITButton.addEventListener('click', function (event) {
      event.preventDefault();
      const ITTable = document.getElementById('itNewMessageTable');
      ITTable.style.display = (ITTable.style.display === 'none' || ITTable.style.display === '') 
        ? 'block' 
        : 'none';
    });
  }

  // it done message
  const toggledoneITButton = document.getElementById('toggleButtonDone');
  if (toggledoneITButton) {
    toggledoneITButton.addEventListener('click', function (event) {
      event.preventDefault();
      const ITTable = document.getElementById('DoneMessagesTable');
      ITTable.style.display = (ITTable.style.display === 'none' || ITTable.style.display === '') 
        ? 'block'
        : 'none';
    });
  }

//Search by Possition
document.getElementById('searchPosition').addEventListener('input', function() {
  const searchValue = this.value.toLowerCase().trim();
  const tableRows = document.querySelectorAll('#declinedMessagesTable .lists');

  tableRows.forEach(row => {
    const position = row.cells[4].textContent.toLowerCase();
    if (position.includes(searchValue)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});