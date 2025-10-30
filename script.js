const slider = document.querySelector(".slider-track");

slider.addEventListener("mouseover", () => {
  slider.style.animationPlayState = "paused";
});

slider.addEventListener("mouseout", () => {
  slider.style.animationPlayState = "running";
});

document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll(".nav_link");
  const pages = document.querySelectorAll(".page");

  links.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = link.getAttribute("href").substring(1);
      pages.forEach((page) => (page.style.display = "none"));
      document.getElementById(targetId).style.display = "block";
      links.forEach((l) => l.classList.remove("active"));
      link.classList.add("active");
    });
  });
});
