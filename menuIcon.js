// Toggle icon and navbar
let menuIcon = document.querySelector('#menu-icon');
let navbar = document.querySelector('.nav');

menuIcon.onclick = () => {
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active');
};

// Scroll sections and manage active links
let sections = document.querySelectorAll('section');
let navlinks = document.querySelectorAll('header nav a');

window.onscroll = () => {
    let top = window.scrollY;

    // Update active link based on current scroll position
    sections.forEach(sec => {
        let offset = sec.offsetTop - 100;
        let height = sec.offsetHeight;
        let id = sec.getAttribute('id');

        if (top >= offset && top < offset + height) {
            navlinks.forEach(link => {
                link.classList.remove('active');
            });
            document.querySelector('header nav a[href*=' + id + ']').classList.add('active');
        }
    });

    // Sticky header
    let header = document.querySelector('header');
    header.classList.toggle('sticky', top > 100);

    // Close navbar when a link is clicked or scroll occurs
    if (navbar.classList.contains('active') && top > 100) {
        navbar.classList.remove('active');
        menuIcon.classList.remove('bx-x');
    }
};

// Close navbar when a navigation link is clicked
navlinks.forEach(link => {
    link.addEventListener('click', () => {
        navbar.classList.remove('active');
        menuIcon.classList.remove('bx-x');
    });
});

// Display section based on the clicked navbar item
var navbars = document.getElementsByClassName("navbar");
var displaysections = document.getElementsByClassName("displaysections");

function openSection(sectionName) {
    // Remove active classes from all navbars and sections
    for (let navbar of navbars) {
        navbar.classList.remove("activeBar");
    }
    for (let section of displaysections) {
        section.classList.remove("activeSection");
    }

    // Add active class to the clicked navbar item
    event.currentTarget.classList.add("activeBar");

    // Add active class to the corresponding section
    let sectionToShow = document.getElementById(sectionName);
    if (sectionToShow) {
        sectionToShow.classList.add("activeSection");
    } else {
        console.error(`Section with id ${sectionName} not found.`);
    }
}
// section send  message type letter selector 
var tablinks = document.getElementsByClassName("tab-links");
var tabcontents = document.getElementsByClassName("tab-contents");

        function opentab(tabname){
            for(tablink of tablinks){
                tablink.classList.remove("activelink");
            }
            for(tabcontent of tabcontents){
                tabcontent.classList.remove("activetab");
            }
            event.currentTarget.classList.add("activelink");
            document.getElementById(tabname).classList.add("activetab");
        }

// validation phone number and email for send message
function validateForms(event) {
    let email = document.forms['myForm']['emailAddress'].value.trim();
    let mobile = document.forms['myForm']['mobileNum'].value.trim();

    let emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    let mobilePattern = /^[0-9]+$/;

    let isValid = true;

    if (!mobilePattern.test(mobile)) {
        alert("Mobile number must be a number");
        isValid = false;
    }

    if (!emailPattern.test(email)) {
        alert("Email must contain @gmail.com");
        isValid = false;
    }

    // Prevent form submission if any validation fails
    if (!isValid) {
        event.preventDefault();
    }

    // If valid, allow form submission
    return isValid;
}


