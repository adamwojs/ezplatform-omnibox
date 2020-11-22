((window, document, Routing, eZ) => {
    const getSuggestionsEndpoint = (query, limit, types) => {
        limit = limit || 5;
        types = types || [];

        return Routing.generate('ezplatform.omnibox.search', {
            'query': query,
            'limit': limit,
            'types': types,
            'context': eZ.adminUiConfig.suggestionContext
        });
    }

    const handleResponse = (response) => {
        if (!response.ok) {
            throw Error(response.statusText);
        }

        return response.json();
    }

    const fetchSuggestions = (query, limit, types) => {
        const request = new Request(getSuggestionsEndpoint(query, limit, types), {
            method: 'POST',
            mode: 'same-origin',
            credentials: 'same-origin',
        })

        return fetch(request).then(handleResponse);
    }

    const form = document.getElementById('omnibox');
    const input = form.querySelector('input');

    document.addEventListener('DOMContentLoaded', () => {
        autocomplete(input, {hint: true}, [
            {
                name: 'content',
                displayKey: 'name',
                source: (query, callback) => {
                    fetchSuggestions(query, null, ['content']).then(callback);
                },
                templates: {
                    suggestion: (suggestion, answer) => {
                        return `
                            <h6 class="mt-0">${suggestion.name}</h6>
                            
                            <p class="aa-suggestion-meta">
                                <svg class="ez-icon ez-icon--small ez-icon--base-dark ez-icon-${suggestion.contentType.identifier}">
                                    <use xlink:href="/bundles/ezplatformadminuiassets/vendors/webalys/streamlineicons/all-icons.svg#${suggestion.contentType.identifier}"></use>
                                </svg>                                                                                                
                                ${suggestion.contentType.name} under ${suggestion.parentName}
                            </p> 
                        `;
                    }
                }
            },
            {
                name: 'command',
                displayKey: 'displayText',
                source: (query, callback) => {
                    fetchSuggestions(query, null, ['command']).then(callback);
                },
                templates: {
                    suggestion: (suggestion, answer) => {
                        return `${suggestion.displayText}`;
                    }
                }
            }
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
})(window, window.document, window.Routing, window.eZ);
