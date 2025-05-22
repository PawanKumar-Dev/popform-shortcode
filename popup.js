document.addEventListener("DOMContentLoaded", function () {
  const overlay = document.getElementById("popform-overlay");
  const closeBtn = document.querySelector(".popform-close");

  // Show after delay (read from data-delay attribute)
  const delay = overlay && overlay.getAttribute('data-delay') ? parseInt(overlay.getAttribute('data-delay'), 10) : 1000;
  const behavior = overlay && overlay.getAttribute('data-behavior') ? overlay.getAttribute('data-behavior') : 'always';

  function showPopup() {
    overlay.style.display = "flex";
    if (behavior === 'once') {
      sessionStorage.setItem('popform_shown', '1');
    } else if (behavior === 'user') {
      localStorage.setItem('popform_shown', '1');
    }
  }

  if (behavior === 'once') {
    if (!sessionStorage.getItem('popform_shown')) {
      setTimeout(showPopup, delay);
    }
  } else if (behavior === 'user') {
    if (!localStorage.getItem('popform_shown')) {
      setTimeout(showPopup, delay);
    }
  } else {
    setTimeout(showPopup, delay);
  }

  // Close button
  closeBtn.addEventListener("click", () => {
    overlay.style.display = "none";
  });

  // Close on click outside modal
  overlay.addEventListener("click", (e) => {
    if (e.target === overlay) {
      overlay.style.display = "none";
    }
  });
});
