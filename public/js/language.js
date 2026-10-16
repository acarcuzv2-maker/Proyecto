function cambiarIdioma(idioma) {
    document.documentElement.lang = idioma;

    document.querySelectorAll('[data-es][data-en]').forEach(elemento => {
        elemento.textContent = elemento.dataset[idioma];
    });

    document.getElementById('ingles')?.classList.toggle('activo', idioma === 'en');
    document.getElementById('espanol')?.classList.toggle('activo', idioma === 'es');

    localStorage.setItem('idiomaPreferido', idioma);
}

document.addEventListener('DOMContentLoaded', () => {
    const idiomaGuardado = localStorage.getItem('idiomaPreferido') || 'es';
    cambiarIdioma(idiomaGuardado);
});