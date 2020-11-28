((global, doc, eZ) => {
    const attachSpeechRecognizer = (input, onResult) => {
        const SpeechRecognition = global.SpeechRecognition || global.webkitSpeechRecognition;

        if (SpeechRecognition === undefined) {
            // Web Speech API is undefined
            return ;
        }

        const recognizer = new SpeechRecognition();
        recognizer.continuous = true;
        recognizer.interimResults = false
        recognizer.onresult = onResult;

        input.addEventListener('blur', (e) => {
            recognizer.stop()
        });

        input.addEventListener('focus', (e) => {
            recognizer.start();
        });
    }

    const form = doc.getElementById('omnibox');
    const input = form.querySelector('input');

    doc.addEventListener('DOMContentLoaded', () => {
        const search = autocomplete(input, {
            openOnFocus: true,
            hint: true
        }, eZ.omnibox.getProviders());

        search.on('autocomplete:selected', (e, suggestion, dataset) => {
            if (suggestion && suggestion.actionUrl.length !== 0) {
                global.location = suggestion.actionUrl;
            }
        });

        attachSpeechRecognizer(input, (event) => {
            for (let i = event.resultIndex; i < event.results.length; i++) {
                const result = event.results[i];
                if (result.isFinal) {
                    search.autocomplete.setVal(search.autocomplete.getVal() +  ' ' + result[0].transcript);
                }
            }
        });
    });

    doc.addEventListener('keydown', (e) => {
        if (e.altKey && e.key === '/') {
            input.focus();
        }
    });
})(window, window.document, window.eZ);
