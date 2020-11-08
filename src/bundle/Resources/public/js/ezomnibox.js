((window, document) => {
    const form = document.getElementById('omnibox');

    document.addEventListener('keydown', (e) => {
        if (e.altKey && e.key === '/') {
            form.querySelector('input').focus();
        }
    })
})(window, window.document);
