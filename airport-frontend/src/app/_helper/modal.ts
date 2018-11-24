export function openModal(id: string) {
  document.getElementById(id).parentElement.style.display = 'block';
  document.getElementById(id).style.display = 'block';
}

export function closeModal(id: string) {
  document.getElementById(id).parentElement.style.display = 'none';
  document.getElementById(id).style.display = 'none';
}
