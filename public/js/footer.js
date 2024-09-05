
  window.addEventListener('scroll', function() {
    const footer = document.getElementById('footer');
    const scrollPosition = window.innerHeight + window.scrollY;
    const documentHeight = document.body.offsetHeight;

    // Se o usuário chegou ao final da página, mostre o footer
    if (scrollPosition >= documentHeight) {
      footer.style.display = 'block';
    } else {
      footer.style.display = 'none';
    }
  });