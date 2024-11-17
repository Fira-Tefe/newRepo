/* toggle style swithcer */
const styleSwitchToggler = document.querySelector(".style-switch-toggler");
styleSwitchToggler.addEventListener("click", () => {
  document.querySelector(".style-switch").classList.toggle("open");
});
/* hide style switch on scoll */
window.addEventListener("scroll", () => {
  if (document.querySelector(".style-switch").classList.contains("open")) {
    document.querySelector(".style-switch").classList.remove("open");
  }
});
/* theme colors */
const alternateStyles = document.querySelectorAll(".alternate-style");
function setActiveStyle(color) {
  alternateStyles.forEach((style) => {
    if (color === style.getAttribute("title")) {
      style.removeAttribute("disabled");
    } else {
      style.setAttribute("disabled", "true");
    }
  });
}
/* theme light and dark */
const dayNight = document.querySelector(".day-night");
dayNight.addEventListener("click", () => {
  dayNight.querySelector("i").classList.toggle("bx-sun");
  dayNight.querySelector("i").classList.toggle("bx-moon");
  document.body.classList.toggle("dark");
});
window.addEventListener("load", () => {
  if (document.body.classList.contains("dark")) {
    dayNight.querySelector("i").classList.add("bx-sun");
  } else {
    dayNight.querySelector("i").classList.add("bx-moon");
  }
});

//
/* toggle language swithcer */
const styleLangugeToggler = document.querySelector(".style-language");
styleLangugeToggler.addEventListener("click", () => {
  document.querySelector(".language").classList.toggle("open");
});
/* hide style language on scoll */
window.addEventListener("scroll", () => {
  if (document.querySelector(".language").classList.contains("open")) {
    document.querySelector(".language").classList.remove("open");
  }
});