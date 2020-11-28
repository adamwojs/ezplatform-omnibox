((global, doc, Routing, eZ) => {
    const getSuggestionsContext = () => {
        return eZ.adminUiConfig.suggestionContext;
    }

    const getProviders = () => {
        const providers = [];
        const event = new CustomEvent('ezplatform.omnibox.init', {
            detail: {
                providers: providers
            }
        });

        doc.dispatchEvent(event);

        return providers;
    }

    const getSuggestionsEndpoint = (query, limit, types) => {
        limit = limit || 5;
        types = types || [];

        return Routing.generate('ezplatform.omnibox.search', {
            'query': query,
            'limit': limit,
            'types': types,
            'context': getSuggestionsContext()
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
        });

        return fetch(request).then(handleResponse);
    }

    eZ.addConfig('omnibox', {
        fetchSuggestions,
        getProviders,
        getSuggestionsContext
    });
})(window, window.document, window.Routing, window.eZ);
