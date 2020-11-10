((window, document, Routing) => {
    const getSuggestionsEndpoint = (query) => {
        return Routing.generate('ezplatform.omnibox.search', {
            'query': query
        });
    }

    const handleResponse = (response) => {
        if (!response.ok) {
            throw Error(response.statusText);
        }

        return response.json();
    }

    const fetchSuggestions = (query) => {
        const request = new Request(getSuggestionsEndpoint(query), {
            method: 'POST',
            mode: 'same-origin',
            credentials: 'same-origin',
        })

        return fetch(request).then(handleResponse);
    }

    const form = document.getElementById('omnibox');
    const input = form.querySelector('input');

    document.addEventListener('DOMContentLoaded', () => {
        autocomplete(input, {hint: false}, [
            {
                source: (query, callback) => {
                    fetchSuggestions(query).then(callback);
                },
                displayText: 'text',
                templates: {
                    suggestion: (suggestion, answer) => {
                        return autocomplete.escapeHighlightedString(
                            suggestion.text,
                            '<span class="highlighted">',
                            '</span>'
                        );
                    }
                }
            },
        ]).on('autocomplete:selected', (e, suggestion, dataset) => {
            if (suggestion.actionUrl.length !== 0) {
                window.location = suggestion.actionUrl;
            }
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.altKey && e.key === '/') {
            input.focus();
        }
    })
})(window, window.document, window.Routing);
