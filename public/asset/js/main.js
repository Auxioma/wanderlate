// Fonction pour le span de la navigation
(function () {
  const tabList = document.getElementById('myTab');
  const bg = tabList.querySelector('.nav-indicator');

  function moveBg() {
    const active = tabList.querySelector(".nav-link.active");
    if (!active) return;

    const itemLeft = active.offsetLeft;
    const itemWidth = active.offsetWidth;

    bg.style.width = itemWidth + "px";
    bg.style.transform = `translateX(${itemLeft}px)`;
  }

  document.addEventListener("DOMContentLoaded", moveBg);

  tabList.querySelectorAll(".nav-link").forEach(link => {
    link.addEventListener("shown.bs.tab", moveBg);
  });

  window.addEventListener("resize", moveBg);
})();
