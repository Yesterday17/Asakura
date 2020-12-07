export function clearButterBar() {
  document.querySelectorAll(".butterBar").forEach((b) => b.remove());
}

export function createButterbar(message, showtime = 6000) {
  clearButterbar();

  const bar = document.createElement("div");
  bar.classList.add("butterBar", "butterBar--center");
  const bp = document.createElement("p");
  bp.classList.add("butterBar-message");
  bp.innerHTML = message;
  bar.appendChild(bp);
  document.body.appendChild(bar);
  setTimeout(() => bar.remove(), showtime);
}
