// /js/vehicle_form.js
(function () {
  function clampCapacity(input) {
    let v = parseInt(input.value || "0", 10);
    if (isNaN(v)) v = 1;
    if (v < 1) v = 1;
    if (v > 4) v = 4;
    input.value = v;
  }

  function init() {
    const cap = document.getElementById("capacity");
    if (!cap) return;

    cap.setAttribute("min", "1");
    cap.setAttribute("max", "4");

    cap.addEventListener("input", () => clampCapacity(cap));
    cap.addEventListener("change", () => clampCapacity(cap));

    const form = cap.closest("form");
    if (form) {
      form.addEventListener("submit", (e) => {
        const v = parseInt(cap.value || "0", 10);
        if (isNaN(v) || v < 1 || v > 4) {
          e.preventDefault();
          alert("La capacidad debe estar entre 1 y 4 asientos.");
          clampCapacity(cap);
          cap.focus();
        }
      });
    }
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
