document.addEventListener("DOMContentLoaded", function() {
    if (document.querySelectorAll("[toast-list]").length > 0 || 
        document.querySelectorAll("[data-choices]").length > 0 || 
        document.querySelectorAll("[data-provider]").length > 0) {

        const scripts = [
            "https://cdn.jsdelivr.net/npm/toastify-js",
            `${PATH_ROOT}/assets/libs/choices.js/public/assets/scripts/choices.min.js`,
            `${PATH_ROOT}/assets/libs/flatpickr/flatpickr.min.js`
        ];

        scripts.forEach(src => {
            const script = document.createElement("script");
            script.type = "text/javascript";
            script.src = src;
            document.head.appendChild(script);
        });
    }
});
