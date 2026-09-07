(function () {
  if (!document.querySelector('.proj-screen-cell img')) return;

  var overlay = document.createElement('div');
  overlay.id = 'lb-overlay';
  overlay.innerHTML =
    '<button id="lb-close" aria-label="close">✕</button>' +
    '<button id="lb-prev" aria-label="previous">‹</button>' +
    '<img id="lb-img" src="" alt="" />' +
    '<button id="lb-next" aria-label="next">›</button>';
  document.body.appendChild(overlay);

  var imgEl   = document.getElementById('lb-img');
  var closeEl = document.getElementById('lb-close');
  var prevEl  = document.getElementById('lb-prev');
  var nextEl  = document.getElementById('lb-next');
  var images  = [];
  var current = 0;

  document.querySelectorAll('.proj-screen-cell img').forEach(function (el, i) {
    images.push({ src: el.src, alt: el.alt });
    var cell = el.closest('.proj-screen-cell');
    cell.style.cursor = 'zoom-in';
    cell.addEventListener('click', function () { open(i); });
  });

  function open(i) {
    current = i;
    imgEl.src = images[i].src;
    imgEl.alt = images[i].alt;
    overlay.classList.add('lb-active');
    document.body.style.overflow = 'hidden';
  }

  function closeLb() {
    overlay.classList.remove('lb-active');
    document.body.style.overflow = '';
    imgEl.src = '';
  }

  function step(dir) {
    current = (current + dir + images.length) % images.length;
    imgEl.src = images[current].src;
    imgEl.alt = images[current].alt;
  }

  closeEl.addEventListener('click', closeLb);
  prevEl.addEventListener('click', function () { step(-1); });
  nextEl.addEventListener('click', function () { step(1); });
  overlay.addEventListener('click', function (e) { if (e.target === overlay) closeLb(); });
  document.addEventListener('keydown', function (e) {
    if (!overlay.classList.contains('lb-active')) return;
    if (e.key === 'Escape') closeLb();
    if (e.key === 'ArrowLeft') step(-1);
    if (e.key === 'ArrowRight') step(1);
  });
})();
