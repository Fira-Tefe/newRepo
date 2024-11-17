// Handling navigation and section activation
var navlinks = document.getElementsByClassName("navlinks");
var sectionLinks = document.getElementsByClassName("sections");

function convertsection(namecontent) {
    // Remove active classes from all navbars and sections
    for (let navlink of navlinks) {
        navlink.classList.remove("activenav");
    }
    for (let sectionLink of sectionLinks) {
        sectionLink.classList.remove("activesec");
    }

    event.currentTarget.classList.add("activenav");
    let sectionShow = document.getElementById(namecontent);
    if (sectionShow) {
        sectionShow.classList.add("activesec");
    } else {
        console.error(`Section with id ${namecontent} not found.`);
    }
}

// Handling row approval and decline
function aproveConverter(rowId) {
    if (confirm("Are you sure you want to Approve?"))
        updateRowStatus(rowId, 'approve', 'ON', 'OFF', "lightgreen");
}

function declineConverter(rowId) {
    if (confirm("Are you sure you want to delete this letter?")) {
        updateRowStatus(rowId, 'decline', 'ON', 'OFF', "lightcoral");
    }
}

// Updating row status with visual and database updates
function updateRowStatus(rowId, actionType, newStatus, resetStatus, highlightColor) {
    var row = document.querySelector(`tr[data-row-id='${rowId}']`);
    var actionCell = row.querySelector(`td:nth-child(${actionType === 'approve' ? 4 : 5}) h4`);
    var oppositeCell = row.querySelector(`td:nth-child(${actionType === 'approve' ? 5 : 4}) h4`);

    actionCell.innerText = newStatus;
    oppositeCell.innerText = resetStatus;
    row.style.backgroundColor = newStatus === 'ON' ? highlightColor : "";

    // Get the selected department
    var departmentSelect = row.querySelector('.department-select');
    var selectedDepartment = departmentSelect ? departmentSelect.value : '';

    sendUpdateRequest(rowId, actionType, newStatus, selectedDepartment);
    sendUpdateRequest(rowId, actionType === 'approve' ? 'decline' : 'approve', resetStatus);
}

// Sending AJAX requests to update the database and trigger email notifications
function sendUpdateRequest(rowId, actionType, status, department = '') {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./updateStatus.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var data = "rowId=" + rowId + "&actionType=" + actionType + "&status=" + status + "&department=" + encodeURIComponent(department);
    xhr.send(data);

    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                console.log(`Update successful for row ${rowId}: ${actionType} = ${status}`);
            } else {
                console.error(`Failed to update row ${rowId}: ${response.message}`);
            }
        } else {
            console.error(`Request failed with status: ${xhr.status}`);
        }
    };
}

// Handling department changes
document.addEventListener('change', function(event) {
    if (event.target.classList.contains('department-select')) {
        const rowId = event.target.getAttribute('data-row-id');
        const department = event.target.value;

        sendDepartmentUpdateRequest(rowId, department);
    }
});

function sendDepartmentUpdateRequest(rowId, department) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./updateStatus.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var data = "rowId=" + rowId + "&actionType=department&status=" + department;
    xhr.send(data);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                console.log(`Department updated successfully for row ${rowId}`);
            } else {
                console.error(`Failed to update department for row ${rowId}: ${response.message}`);
            }
        } else {
            console.error(`Request failed with status: ${xhr.status}`);
        }
    };
}

// Form validation
function validateForms(event) {
    let fullname = document.forms['signForm']['fullname'].value.trim();
    let username = document.forms['signForm']['username'].value.trim();
    let password = document.forms['signForm']['password'].value;
    let cpassword = document.forms['signForm']['cpassword'].value;
    let namePattern = /^[A-Za-z ]+$/;

    if (!namePattern.test(fullname)) {
        alert("Full name must contain only letters. Please try again!!!");
        return false;
    }

    if (password !== cpassword) {
        alert("Password mismatch, Please try again!!!");
        return false;
    }

    return true;
}
// validation for system admin

function systemvalidateForms(event) {
    let fullname = document.forms['systemsignForm']['Fullname'].value.trim();
    let username = document.forms['systemsignForm']['setUsername'].value.trim();
    let password = document.forms['systemsignForm']['setPassword'].value;
    let cpassword = document.forms['systemsignForm']['seCpassword'].value;
    let namePattern = /^[A-Za-z ]+$/;

    if (!namePattern.test(fullname)) {
        alert("Full name must contain only letters. Please try again!!!");
        return false;
    }

    if (password !== cpassword) {
        alert("Password mismatch, Please try again!!!");
        return false;
    }

    return true;
}
// Profile image upload preview
function handleProfileUpload(inputElement, imgElementId) {
    let profilepic = document.getElementById(imgElementId);
    inputElement.onchange = function() {
        if (inputElement.files && inputElement.files[0]) {
            profilepic.src = URL.createObjectURL(inputElement.files[0]);
        }
    };
}

// Initialize upload previews
handleProfileUpload(document.getElementById("input-file"), "profile-pic");
handleProfileUpload(document.getElementById("computerinput-file"), "computerprofile-pic");
handleProfileUpload(document.getElementById("itinput-file"), "itprofile-pic");

// the restore update



