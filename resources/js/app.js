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

// Detecta si el navegador soporta el acordeón exclusivo nativo de <details name>
function exclusiveDetailsSupported() {
    const a = document.createElement("details");
    const b = document.createElement("details");
    a.name = b.name = "__details_support_test__";
    document.body.append(a, b);
    a.open = true;
    b.open = true;
    const supported = !a.open; // abrir b debería haber cerrado a
    a.remove();
    b.remove();
    return supported;
}

// Fallback: en navegadores sin soporte nativo, al abrir un <details name="acciones">
// cerramos el resto del mismo grupo para no tener dos abiertos a la vez.
if (!exclusiveDetailsSupported()) {
    const items = document.querySelectorAll('details[name="acciones"]');

    items.forEach((item) => {
        item.addEventListener("toggle", () => {
            if (!item.open) return;

            items.forEach((other) => {
                if (other !== item) {
                    other.open = false;
                }
            });
        });
    });
}
