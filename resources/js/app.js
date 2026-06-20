// Crear un IntersectionObserver
const observer = new IntersectionObserver(
    (entries, observer) => {
        entries.forEach((entry) => {
            // Si el elemento está visible
            if (entry.isIntersecting) {
                entry.target.classList.add("fade-in-visible"); // Agrega la clase de fade-in visible
                observer.unobserve(entry.target); // Deja de observar el elemento una vez que se hace visible
            }
        });
    },
    { threshold: 0.1 },
); // 10% del elemento debe estar visible para que se dispare el evento

// Selecciona todos los elementos con la clase fade-in
document.querySelectorAll(".fade-in").forEach((element) => {
    observer.observe(element); // Comienza a observar el elemento
});
