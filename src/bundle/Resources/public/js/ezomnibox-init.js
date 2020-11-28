((global, doc, eZ) => {
    const form = doc.getElementById('omnibox');
    const input = form.querySelector('input');

    doc.addEventListener('DOMContentLoaded', () => {
        const providers = eZ.omnibox.getProviders();
        const onAutocompleteSelected = (e, suggestion, dataset) => {
            if (suggestion && suggestion.actionUrl.length !== 0) {
                global.location = suggestion.actionUrl;
            }
        };

        autocomplete(input, {hint: true}, providers)
            .on('autocomplete:selected', onAutocompleteSelected);
    });

    doc.addEventListener('keydown', (e) => {
        if (e.altKey && e.key === '/') {
            input.focus();
        }
    });
})(window, window.document, window.eZ);
