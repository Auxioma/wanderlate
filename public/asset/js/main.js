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


const track = document.querySelector('.slider-track');
let startX = 0;
let current = 0;
let prev = 0;
let isDragging = false;

function getX(e) {
  if (e.touches) return e.touches[0].clientX;
  return e.clientX;
}

function onStart(e) {
  isDragging = true;
  startX = getX(e);
  track.style.transition = 'none';
}

function onMove(e) {
  if (!isDragging) return;
  const dx = getX(e) - startX;
  current = prev + dx;
  track.style.transform = `translateX(${current}px)`;
}

document.addEventListener("DOMContentLoaded", function() {

  const track = document.querySelector('.slider-track');
  if (!track) return; // Sécurité : empêche les erreurs Symfony

  let startX = 0;
  let current = 0;
  let prev = 0;
  let dragging = false;

  function pos(e) {
    return e.touches ? e.touches[0].clientX : e.clientX;
  }

  function start(e) {
    dragging = true;
    startX = pos(e);
    track.style.transition = 'none';
  }

  function move(e) {
    if (!dragging) return;
    const dx = pos(e) - startX;
    current = prev + dx;
    track.style.transform = `translateX(${current}px)`;
  }

  function end() {
    if (!dragging) return;
    dragging = false;

    const cardWidth = document.querySelector('.property-card').offsetWidth;
    const gap = 14;
    const full = cardWidth + gap;

    let index = Math.round(-current / full);
    index = Math.max(0, Math.min(index, track.children.length - 1));

    current = -index * full;
    prev = current;

    track.style.transition = '.3s cubic-bezier(.22,.9,.32,1)';
    track.style.transform = `translateX(${current}px)`;
  }

  track.addEventListener('touchstart', start, { passive: true });
  track.addEventListener('touchmove', move, { passive: false });
  track.addEventListener('touchend', end);

  track.addEventListener('mousedown', start);
  window.addEventListener('mousemove', move);
  window.addEventListener('mouseup', end);

});